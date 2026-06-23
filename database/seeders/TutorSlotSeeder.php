<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

use App\Services\BookingService;

class TutorSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $tutors = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'tutor');
        })->with('groups')->with('subjects')->get();
        
        foreach ($tutors as $tutor) {
            foreach ($tutor->subjects as $subject) {
                $slotsData = [
                    'subject_group_id' => $subject->id,
                    'date_range'       => now()->toDateString() . " to " . now()->addMonths(2)->toDateString(),
                    'session_fee'      =>  $subject->hour_rate,
                    'description'      => '<strong>Overview</strong><br>
                                        This session will introduce students to the foundational principles of web design, focusing on creating visually appealing and user-friendly websites. Participants will gain hands-on experience in using industry-standard tools and techniques to develop responsive and accessible web pages.<br><br>
                                        <strong>What will be covered</strong><br>
                                        <ul>
                                            <li><strong>HTML & CSS Basics:</strong> Understanding the building blocks of web pages, including structure, styling, and layout.</li>
                                            <li><strong>Responsive Design:</strong> Learning how to create websites that adapt seamlessly to different screen sizes and devices.</li>
                                            <li><strong>Typography & Color Theory:</strong> Exploring the impact of typography and color choices on user experience and design aesthetics.</li>
                                            <li><strong>Web Design Tools:</strong> Introduction to popular tools like Adobe XD, Figma, or Sketch for designing website prototypes.</li>
                                            <li><strong>Accessibility:</strong> Ensuring websites are accessible to all users, including those with disabilities.</li>
                                            <li><strong>Introduction to JavaScript:</strong> Adding interactivity to web pages with basic JavaScript.</li>
                                            <li><strong>Best Practices:</strong> Understanding the best practices for modern web design, including SEO and performance optimization.</li>
                                        </ul>'
                ];

                $slotsData['start_time'] = $this->randomTime('09:00', '16:00');
                $totalSessionTime = mt_rand(60, 120);

                $slotsData['duration'] = mt_rand(30, $totalSessionTime - 10);
                $slotsData['break'] = $totalSessionTime - $slotsData['duration'];

                $slotsData['spaces'] = mt_rand(1, 10);

                $startTime = strtotime($slotsData['start_time']);
                $endTime = $startTime + ($slotsData['duration'] + $slotsData['break']) * 60;
                $slotsData['end_time'] = date('H:i', $endTime);
                (new BookingService($tutor))->addUserSubjectGroupSessions($slotsData); 
            }
        }
    }
    function randomTime($start, $end) {
        $startTimestamp = strtotime($start);
        $endTimestamp = strtotime($end);
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        return date('H:i', $randomTimestamp);
    }
}
