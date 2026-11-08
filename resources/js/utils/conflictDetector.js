/**
 * DAEI MINI — Time Overlap Conflict Detection Engine
 * Pure mathematical linear interval overlap detector.
 *
 * Overlap Condition: (newStart < existingEnd) AND (newEnd > existingStart)
 * Note: Boundaries that touch exactly (e.g. 10:00 end and 10:00 start) are NOT conflicts.
 */

/**
 * Converts a 24-hour ('HH:MM') or 12-hour ('hh:mm AM/PM') time string to total minutes from midnight.
 * @param {string} timeStr - e.g. "09:00", "14:15", "09:00 AM", "02:15 PM"
 * @returns {number} minutes from midnight (0 - 1439)
 */
export function timeToMinutes(timeStr) {
    if (!timeStr || typeof timeStr !== 'string') return 0;
    const clean = timeStr.trim();

    // Check for 12-hour AM/PM format
    const match12 = clean.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)?$/i);
    if (!match12) return 0;

    let hours = parseInt(match12[1], 10);
    const minutes = parseInt(match12[2], 10);
    const modifier = match12[3] ? match12[3].toUpperCase() : null;

    if (modifier === 'PM' && hours < 12) {
        hours += 12;
    } else if (modifier === 'AM' && hours === 12) {
        hours = 0;
    }

    return (hours * 60) + (isNaN(minutes) ? 0 : minutes);
}

/**
 * Converts total minutes from midnight into 24-hour "HH:MM" string.
 * @param {number} totalMinutes
 * @returns {string} e.g. "09:00", "14:30"
 */
export function minutesToTime(totalMinutes) {
    const safeMin = Math.max(0, Math.floor(totalMinutes || 0));
    const hours = Math.floor(safeMin / 60) % 24;
    const minutes = safeMin % 60;
    const pad = (n) => (n < 10 ? '0' + n : String(n));
    return `${pad(hours)}:${pad(minutes)}`;
}

/**
 * Formats a time string into standard 12-hour format with AM/PM.
 * @param {string} timeStr - e.g. "09:00", "14:15"
 * @returns {string} e.g. "09:00 AM", "02:15 PM"
 */
export function format12Hour(timeStr) {
    if (!timeStr) return '';
    const mins = timeToMinutes(timeStr);
    let hours = Math.floor(mins / 60) % 24;
    const minutes = mins % 60;
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    const pad = (n) => (n < 10 ? '0' + n : String(n));
    return `${pad(hours)}:${pad(minutes)} ${ampm}`;
}

/**
 * Formats duration in minutes to human readable string (e.g. "30-minute overlap", "1h 15m")
 * @param {number} minutes
 * @returns {string}
 */
export function formatDuration(minutes) {
    if (!minutes || minutes <= 0) return '0 minutes';
    const hrs = Math.floor(minutes / 60);
    const mins = minutes % 60;
    if (hrs > 0 && mins > 0) return `${hrs} hr ${mins} min`;
    if (hrs > 0) return `${hrs} hr${hrs > 1 ? 's' : ''}`;
    return `${mins} min`;
}

/**
 * Evaluates pure interval overlap between two time spans in minutes.
 * (newStart < existingEnd) AND (newEnd > existingStart)
 *
 * @param {number} startA - start in minutes
 * @param {number} endA - end in minutes
 * @param {number} startB - start in minutes
 * @param {number} endB - end in minutes
 * @returns {boolean}
 */
export function isIntervalOverlapping(startA, endA, startB, endB) {
    return (startA < endB) && (endA > startB);
}

/**
 * Validates start and end time.
 * End time must be strictly later than start time.
 * @param {string} startTime
 * @param {string} endTime
 * @returns {{ valid: boolean, error?: string }}
 */
export function validateActivityTimes(startTime, endTime) {
    if (!startTime || !endTime) {
        return { valid: false, error: 'Both start time and end time are required.' };
    }
    const startMins = timeToMinutes(startTime);
    const endMins = timeToMinutes(endTime);

    if (endMins <= startMins) {
        return { valid: false, error: 'End time must be later than start time.' };
    }
    return { valid: true };
}

/**
 * Detects all activities that conflict with the candidate activity.
 *
 * Requirements:
 * - Only compare activities that belong to the SAME date.
 * - Condition: (newStart < existingEnd) AND (newEnd > existingStart)
 * - Touching boundaries (newStart === existingEnd or newEnd === existingStart) are NOT conflicts.
 * - When editing, candidate activity does not compare against itself.
 * - Handles multiple conflicting activities.
 *
 * @param {Object} candidate - { id, name, date, startTime, endTime }
 * @param {Array<Object>} existingActivities - Array of activity objects
 * @param {string|number|null} [excludeId=null] - ID of activity being edited to exclude
 * @returns {Array<Object>} List of conflicting activities with overlap metadata
 */
export function findConflicts(candidate, existingActivities = [], excludeId = null) {
    if (!candidate || !candidate.date || !candidate.startTime || !candidate.endTime) {
        return [];
    }

    const { valid } = validateActivityTimes(candidate.startTime, candidate.endTime);
    if (!valid) return [];

    const newStart = timeToMinutes(candidate.startTime);
    const newEnd = timeToMinutes(candidate.endTime);
    const targetDate = candidate.date;
    const ignoreId = excludeId ?? candidate.id;

    const conflicts = [];

    for (const existing of existingActivities) {
        // Exclude the activity itself when editing
        if (ignoreId && String(existing.id) === String(ignoreId)) {
            continue;
        }

        // Only compare activities on the same calendar date
        if (!existing.date || existing.date !== targetDate) {
            continue;
        }

        // Validate existing activity times
        if (!existing.startTime || !existing.endTime) {
            continue;
        }
        const existingStart = timeToMinutes(existing.startTime);
        const existingEnd = timeToMinutes(existing.endTime);
        if (existingEnd <= existingStart) {
            continue;
        }

        // Linear interval overlap: (newStart < existingEnd) AND (newEnd > existingStart)
        if (newStart < existingEnd && newEnd > existingStart) {
            // Calculate exact overlap window
            const overlapStart = Math.max(newStart, existingStart);
            const overlapEnd = Math.min(newEnd, existingEnd);
            const overlapMinutes = Math.max(0, overlapEnd - overlapStart);

            conflicts.push({
                activity: existing,
                conflictingId: existing.id,
                name: existing.name || existing.title || 'Untitled Activity',
                date: existing.date,
                startTime: existing.startTime,
                endTime: existing.endTime,
                formattedStartTime: format12Hour(existing.startTime),
                formattedEndTime: format12Hour(existing.endTime),
                overlapStartMinutes: overlapStart,
                overlapEndMinutes: overlapEnd,
                overlapMinutes,
                overlapDurationLabel: `${overlapMinutes}-minute overlap`,
                formattedOverlapRange: `${format12Hour(minutesToTime(overlapStart))} – ${format12Hour(minutesToTime(overlapEnd))}`,
            });
        }
    }

    // Sort conflicts chronologically by start time
    conflicts.sort((a, b) => timeToMinutes(a.startTime) - timeToMinutes(b.startTime));

    return conflicts;
}

/**
 * Scans all activities in the timetable and returns a Map of activityId -> conflicts array.
 * Useful for visual highlighting on cards.
 *
 * @param {Array<Object>} activities
 * @returns {Object<string, Array>} mapping of activity ID to its conflicting peers
 */
export function buildConflictMap(activities = []) {
    const map = {};
    for (const act of activities) {
        map[act.id] = [];
    }

    for (let i = 0; i < activities.length; i++) {
        const actA = activities[i];
        for (let j = i + 1; j < activities.length; j++) {
            const actB = activities[j];

            if (actA.date !== actB.date) continue;

            const startA = timeToMinutes(actA.startTime);
            const endA = timeToMinutes(actA.endTime);
            const startB = timeToMinutes(actB.startTime);
            const endB = timeToMinutes(actB.endTime);

            if (startA < endB && endA > startB) {
                const overlapStart = Math.max(startA, startB);
                const overlapEnd = Math.min(endA, endB);
                const overlapMinutes = overlapEnd - overlapStart;

                const detailA = {
                    peerId: actB.id,
                    peerName: actB.name,
                    overlapMinutes,
                    formattedRange: `${format12Hour(minutesToTime(overlapStart))} – ${format12Hour(minutesToTime(overlapEnd))}`,
                };

                const detailB = {
                    peerId: actA.id,
                    peerName: actA.name,
                    overlapMinutes,
                    formattedRange: `${format12Hour(minutesToTime(overlapStart))} – ${format12Hour(minutesToTime(overlapEnd))}`,
                };

                map[actA.id].push(detailA);
                map[actB.id].push(detailB);
            }
        }
    }

    return map;
}
