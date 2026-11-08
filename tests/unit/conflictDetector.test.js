import {
    timeToMinutes,
    minutesToTime,
    format12Hour,
    isIntervalOverlapping,
    validateActivityTimes,
    findConflicts,
    buildConflictMap
} from '../../resources/js/utils/conflictDetector.js';

let passed = 0;
let failed = 0;

function assert(condition, message) {
    if (condition) {
        console.log(`  ✓ ${message}`);
        passed++;
    } else {
        console.error(`  ✗ FAIL: ${message}`);
        failed++;
    }
}

console.log('--- RUNNING CONFLICT DETECTOR TESTS ---');

// Test 1: Example 1 from specification
// Weekly Team Standup: 09:00 AM – 12:00 PM
// Ollaa Design Kickoff: 11:30 AM – 12:30 PM
// Expected: 30-minute overlap
console.log('\nTest Case 1: Example 1 (Weekly Team Standup vs Ollaa Design Kickoff)');
const existingList1 = [
    { id: '1', name: 'Weekly Team Standup', date: '2026-11-08', startTime: '09:00', endTime: '12:00' }
];
const candidate1 = {
    id: '2',
    name: 'Ollaa Design Kickoff',
    date: '2026-11-08',
    startTime: '11:30',
    endTime: '12:30'
};
const conflicts1 = findConflicts(candidate1, existingList1);
assert(conflicts1.length === 1, 'Detected exactly 1 conflict');
assert(conflicts1[0].name === 'Weekly Team Standup', 'Conflicting activity is Weekly Team Standup');
assert(conflicts1[0].overlapMinutes === 30, 'Calculated exactly 30-minute overlap');
assert(conflicts1[0].overlapDurationLabel === '30-minute overlap', 'Formatted label is 30-minute overlap');

// Test 2: Example 2 from specification
// Team Collaboration: 02:00 PM – 04:15 PM (14:00 - 16:15)
// Content Approval: 04:00 PM – 06:15 PM (16:00 - 18:15)
// Expected: 15-minute overlap
console.log('\nTest Case 2: Example 2 (Team Collaboration vs Content Approval)');
const existingList2 = [
    { id: '10', name: 'Team Collaboration', date: '2026-11-08', startTime: '14:00', endTime: '16:15' }
];
const candidate2 = {
    id: '11',
    name: 'Content Approval',
    date: '2026-11-08',
    startTime: '16:00',
    endTime: '18:15'
};
const conflicts2 = findConflicts(candidate2, existingList2);
assert(conflicts2.length === 1, 'Detected exactly 1 conflict');
assert(conflicts2[0].overlapMinutes === 15, 'Calculated exactly 15-minute overlap');
assert(conflicts2[0].overlapDurationLabel === '15-minute overlap', 'Formatted label is 15-minute overlap');

// Test 3: Two activities with NO overlap
console.log('\nTest Case 3: Two activities with no overlap (09:00 - 10:00 and 11:00 - 12:00)');
const existingList3 = [
    { id: '20', name: 'Morning Sync', date: '2026-11-08', startTime: '09:00', endTime: '10:00' }
];
const candidate3 = {
    id: '21',
    name: 'Deep Work',
    date: '2026-11-08',
    startTime: '11:00',
    endTime: '12:00'
};
const conflicts3 = findConflicts(candidate3, existingList3);
assert(conflicts3.length === 0, 'Zero conflicts detected for distinct times');

// Test 4: Activities on different dates with identical times
console.log('\nTest Case 4: Identical times on different dates');
const existingList4 = [
    { id: '30', name: 'Monday Standup', date: '2026-11-08', startTime: '09:00', endTime: '10:00' }
];
const candidate4 = {
    id: '31',
    name: 'Tuesday Standup',
    date: '2026-11-09', // Different date!
    startTime: '09:00',
    endTime: '10:00'
};
const conflicts4 = findConflicts(candidate4, existingList4);
assert(conflicts4.length === 0, 'Zero conflicts detected across different dates');

// Test 5: Boundary condition: Activities that touch exactly at start/end boundary
console.log('\nTest Case 5: Touching boundary (09:00 - 10:00 and 10:00 - 11:00)');
const existingList5 = [
    { id: '40', name: 'Slot 1', date: '2026-11-08', startTime: '09:00', endTime: '10:00' }
];
const candidate5 = {
    id: '41',
    name: 'Slot 2',
    date: '2026-11-08',
    startTime: '10:00', // Exactly when Slot 1 ends
    endTime: '11:00'
};
const conflicts5 = findConflicts(candidate5, existingList5);
assert(conflicts5.length === 0, 'Touching boundary is NOT considered an overlap');

// Test 6: Edit activity without creating a conflict
console.log('\nTest Case 6: Editing activity does not compare against itself');
const existingList6 = [
    { id: '50', name: 'Meeting A', date: '2026-11-08', startTime: '09:00', endTime: '10:30' },
    { id: '51', name: 'Meeting B', date: '2026-11-08', startTime: '14:00', endTime: '15:00' }
];
// Editing Meeting A to 09:15 - 10:15 (still in its old window, but excluding its own id '50')
const candidate6 = {
    id: '50',
    name: 'Meeting A (Updated)',
    date: '2026-11-08',
    startTime: '09:15',
    endTime: '10:15'
};
const conflicts6 = findConflicts(candidate6, existingList6, '50');
assert(conflicts6.length === 0, 'Self-comparison excluded, zero conflicts when editing');

// Test 7: Edit activity creating a conflict
console.log('\nTest Case 7: Editing activity into another activity window');
// Editing Meeting A to 14:15 - 15:30 (overlaps with Meeting B 14:00 - 15:00)
const candidate7 = {
    id: '50',
    name: 'Meeting A (Moved to Afternoon)',
    date: '2026-11-08',
    startTime: '14:15',
    endTime: '15:30'
};
const conflicts7 = findConflicts(candidate7, existingList6, '50');
assert(conflicts7.length === 1, 'Conflict detected when edit causes overlap with Meeting B');
assert(conflicts7[0].name === 'Meeting B', 'Conflicting activity is Meeting B');
assert(conflicts7[0].overlapMinutes === 45, 'Calculated 45-minute overlap (14:15 - 15:00)');

// Test 8: Multiple conflicts with one new activity
console.log('\nTest Case 8: Multiple conflicting activities');
const existingList8 = [
    { id: '60', name: 'Sprint Review', date: '2026-11-08', startTime: '09:00', endTime: '10:30' },
    { id: '61', name: 'Design Sync', date: '2026-11-08', startTime: '11:00', endTime: '12:00' },
    { id: '62', name: 'Daily Standup', date: '2026-11-08', startTime: '13:00', endTime: '14:00' }
];
// Long workshop from 10:00 to 12:30 (overlaps with Sprint Review 10:00-10:30 AND Design Sync 11:00-12:00)
const candidate8 = {
    id: '63',
    name: 'All-Hands Workshop',
    date: '2026-11-08',
    startTime: '10:00',
    endTime: '12:30'
};
const conflicts8 = findConflicts(candidate8, existingList8);
assert(conflicts8.length === 2, 'Detected 2 simultaneous conflicts');
assert(conflicts8[0].name === 'Sprint Review', 'First conflict is Sprint Review (30 min)');
assert(conflicts8[1].name === 'Design Sync', 'Second conflict is Design Sync (60 min)');

// Test 9: Time validation
console.log('\nTest Case 9: Time validation');
assert(validateActivityTimes('09:00', '10:00').valid === true, 'End > Start is valid');
assert(validateActivityTimes('10:00', '09:00').valid === false, 'End < Start is invalid');
assert(validateActivityTimes('10:00', '10:00').valid === false, 'End === Start is invalid');

console.log(`\n========================================`);
console.log(`RESULTS: ${passed} passed, ${failed} failed`);
console.log(`========================================\n`);

if (failed > 0) {
    process.exit(1);
}
