<?php

namespace Tests\Feature;

use Tests\TestCase;

class DailyTimetableTest extends TestCase
{
    /**
     * Test the root home page renders user dashboard.
     */
    public function test_home_page_renders_user_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Welcome back');
        $response->assertSee('Five Daily Prayers');
    }

    /**
     * Test the dashboard page returns 200 OK.
     */
    public function test_user_dashboard_page_is_rendered(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Welcome back');
        $response->assertSee('Five Daily Prayers');
    }

    /**
     * Test the /timetable route loads the Task 3 timetable with conflict detector.
     */
    public function test_timetable_route_renders_task3_timetable(): void
    {
        $response = $this->get('/timetable');

        $response->assertStatus(200);
        $response->assertSee('Daily Timetable', false);
        $response->assertSee('Time Conflict Detected');
        $response->assertSee('Weekly Standup vs Ollaa');
        $response->assertSee('Team Collab vs Approval');
        $response->assertSee('Add Activity');
    }

    /**
     * Test Prayer Tracker route.
     */
    public function test_prayers_page_is_rendered(): void
    {
        $response = $this->get('/prayers');

        $response->assertStatus(200);
        $response->assertSee('Five Daily Prayers Tracker');
        $response->assertSee('Fajr');
        $response->assertSee('Salah Compliance');
    }

    /**
     * Test Habits Tracking route.
     */
    public function test_habits_page_is_rendered(): void
    {
        $response = $this->get('/habits');

        $response->assertStatus(200);
        $response->assertSee('Habits', false);
        $response->assertSee('Past 7 Days History');
    }

    /**
     * Test Personal Goals route.
     */
    public function test_goals_page_is_rendered(): void
    {
        $response = $this->get('/goals');

        $response->assertStatus(200);
        $response->assertSee('Personal Development Goals');
        $response->assertSee('+ Set New Goal');
    }

    /**
     * Test Exercise route.
     */
    public function test_exercise_page_is_rendered(): void
    {
        $response = $this->get('/exercise');

        $response->assertStatus(200);
        $response->assertSee('Exercise', false);
        $response->assertSee('+ Log Workout');
    }

    /**
     * Test Quran & Tafseer session tracker route and strict disclaimer.
     */
    public function test_quran_tafseer_page_is_rendered_with_disclaimer(): void
    {
        $response = $this->get('/quran-tafseer');

        $response->assertStatus(200);
        $response->assertSee('Quran', false);
        $response->assertSee('Use your own physical Mus-haf');
        $response->assertSee('Time Tracker Only');
    }

    /**
     * Test Reading Tracking route.
     */
    public function test_reading_page_is_rendered(): void
    {
        $response = $this->get('/reading');

        $response->assertStatus(200);
        $response->assertSee('Reading Tracker');
        $response->assertSee('+ Track New Book');
    }

    /**
     * Test Personal Journal route and confidential notice.
     */
    public function test_journal_page_is_rendered_with_privacy_badge(): void
    {
        $response = $this->get('/journal');

        $response->assertStatus(200);
        $response->assertSee('Personal Journal', false);
        $response->assertSee('End-to-End Privacy Guarantee');
        $response->assertSee('Strictly Confidential');
    }

    /**
     * Test Daily Self-Assessment route.
     */
    public function test_self_assessment_page_is_rendered(): void
    {
        $response = $this->get('/self-assessment');

        $response->assertStatus(200);
        $response->assertSee('Daily Self-Assessment');
        $response->assertSee('Spiritual Focus');
        $response->assertSee('Productivity');
    }

    /**
     * Test Daily Report route and read-only past invariant.
     */
    public function test_daily_report_page_is_rendered(): void
    {
        $response = $this->get('/daily-report');

        $response->assertStatus(200);
        $response->assertSee('Daily Accountability Reports');
        $response->assertSee('Historical Report');
    }

    /**
     * Test Feedback route.
     */
    public function test_feedback_page_is_rendered(): void
    {
        $response = $this->get('/feedback');

        $response->assertStatus(200);
        $response->assertSee('Mentor Feedback');
        $response->assertSee('Ustadh Farhan Al-Mansoor');
    }

    /**
     * Test Admin Dashboard route.
     */
    public function test_admin_dashboard_page_is_rendered(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Supervisory Dashboard');
        $response->assertSee('Mentees Under Supervision');
    }

    /**
     * Test Admin Users route.
     */
    public function test_admin_users_page_is_rendered(): void
    {
        $response = $this->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Mentee Management', false);
        $response->assertSee('Accountability Roster');
    }

    /**
     * Test Admin Groups route.
     */
    public function test_admin_groups_page_is_rendered(): void
    {
        $response = $this->get('/admin/groups');

        $response->assertStatus(200);
        $response->assertSee('Circle Management', false);
        $response->assertSee('Create New Circle');
    }

    /**
     * Test Admin Timetables route.
     */
    public function test_admin_timetables_page_is_rendered(): void
    {
        $response = $this->get('/admin/timetables');

        $response->assertStatus(200);
        $response->assertSee('Mentee Timetable Review');
    }

    /**
     * Test Admin Progress route.
     */
    public function test_admin_progress_page_is_rendered(): void
    {
        $response = $this->get('/admin/progress');

        $response->assertStatus(200);
        $response->assertSee('Compliance Review');
    }

    /**
     * Test Admin Reports route.
     */
    public function test_admin_reports_page_is_rendered(): void
    {
        $response = $this->get('/admin/reports');

        $response->assertStatus(200);
        $response->assertSee('Daily Reports Review');
    }

    /**
     * Test Admin Feedback route.
     */
    public function test_admin_feedback_page_is_rendered(): void
    {
        $response = $this->get('/admin/feedback');

        $response->assertStatus(200);
        $response->assertSee('Provide Mentor Feedback');
    }
}
