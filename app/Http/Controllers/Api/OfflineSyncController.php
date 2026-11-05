<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfflineSyncRecord;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OfflineSyncController extends Controller
{
    public function sync(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'items' => ['required', 'array', 'min:1'],
            'items.*.type' => ['required', Rule::in(['timetable', 'journal'])],
            'items.*.client_id' => ['nullable', 'string', 'max:100', 'required_without:items.*.uuid'],
            'items.*.uuid' => ['nullable', 'string', 'max:100', 'required_without:items.*.client_id'],
            'items.*.created_at' => ['required', 'date'],
            'items.*.submitted_at' => ['required', 'date'],
            'items.*.action' => ['required', Rule::in(['create', 'update'])],
            'items.*.data' => ['required', 'array'],
        ]);

        $validator->after(function ($validator) use ($request): void {
            foreach ($request->input('items', []) as $index => $item) {
                if (
                    isset($item['client_id'], $item['uuid'])
                    && $item['client_id'] !== $item['uuid']
                ) {
                    $validator->errors()->add(
                        "items.$index.client_id",
                        'The client_id and uuid values must match when both are provided.'
                    );
                }
            }
        });

        $validated = $validator->validate();
        $userId = $request->user()->getAuthIdentifier();
        $results = [];

        foreach ($validated['items'] as $item) {
            $clientId = $item['client_id'] ?? $item['uuid'];
            $status = $this->syncItem($userId, $clientId, $item);

            $results[] = [
                'client_id' => $clientId,
                'type' => $item['type'],
                'status' => $status,
            ];
        }

        return response()->json([
            'success' => true,
            'items' => $results,
        ]);
    }

    private function syncItem(int|string $userId, string $clientId, array $item): string
    {
        try {
            return DB::transaction(function () use ($userId, $clientId, $item): string {
                $record = OfflineSyncRecord::query()
                    ->where('user_id', $userId)
                    ->where('client_id', $clientId)
                    ->lockForUpdate()
                    ->first();

                if ($record && $item['action'] === 'create') {
                    abort_if(
                        $record->type !== $item['type'],
                        409,
                        'The client_id is already registered for a different record type.'
                    );

                    return 'already_synced';
                }

                if ($record) {
                    abort_if(
                        $record->type !== $item['type'],
                        409,
                        'The client_id is already registered for a different record type.'
                    );

                    $record->fill([
                        'data' => $item['data'],
                        'submitted_at' => $item['submitted_at'],
                    ])->save();

                    return 'synced';
                }

                OfflineSyncRecord::query()->create([
                    'user_id' => $userId,
                    'client_id' => $clientId,
                    'type' => $item['type'],
                    'data' => $item['data'],
                    'original_created_at' => $item['created_at'],
                    'submitted_at' => $item['submitted_at'],
                ]);

                return 'synced';
            });
        } catch (QueryException $exception) {
            $sqlState = $exception->errorInfo[0] ?? (string) $exception->getCode();
            if (! in_array($sqlState, ['23000', '23505'], true)) {
                throw $exception;
            }

            $recordExists = OfflineSyncRecord::query()
                ->where('user_id', $userId)
                ->where('client_id', $clientId)
                ->exists();

            if (! $recordExists) {
                throw $exception;
            }

            if ($item['action'] === 'create') {
                return 'already_synced';
            }

            DB::transaction(function () use ($userId, $clientId, $item): void {
                $record = OfflineSyncRecord::query()
                    ->where('user_id', $userId)
                    ->where('client_id', $clientId)
                    ->lockForUpdate()
                    ->firstOrFail();

                abort_if(
                    $record->type !== $item['type'],
                    409,
                    'The client_id is already registered for a different record type.'
                );

                $record->fill([
                    'data' => $item['data'],
                    'submitted_at' => $item['submitted_at'],
                ])->save();
            });

            return 'synced';
        }
    }
}
