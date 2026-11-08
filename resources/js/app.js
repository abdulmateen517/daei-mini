import Alpine from 'alpinejs';
import { timetableManager } from './timetableApp.js';
import * as conflictDetector from './utils/conflictDetector.js';

window.Alpine = Alpine;
window.conflictDetector = conflictDetector;

Alpine.data('timetableManager', timetableManager);

Alpine.start();
