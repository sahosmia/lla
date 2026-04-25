<?php

namespace Modules\Courses\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Courses\Models\Curriculum;
use Modules\Courses\Models\Watchtime;

class CurriculumService {

    /**
     * Create a new curriculum.
     *
     * @param array $data
     * @return Curriculum
     */
    public function createCurriculum(array $data) {
        // Add sort_order to $data if not already present
        if (empty($data['sort_order'])) {
            $maxSortOrder = Curriculum::where('section_id', $data['section_id'])->max('sort_order');
            $data['sort_order'] = $maxSortOrder !== null ? $maxSortOrder + 1 : 0;
        }
        return Curriculum::create($data);
    }

    /**
     * Sort curriculum items according to the provided order.
     *
     * @param array $sortedItems An array of curriculum IDs in the desired order
     * @param int $sectionId
     * @return bool
     */
    public function sortCurriculumItems(array $sortedItems, int $sectionId): bool
    {
        try {
            DB::beginTransaction();
            foreach ($sortedItems as $item) {
                Curriculum::where('id', $item['value'])->where('section_id', $sectionId)->update(['sort_order' => $item['order']]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Update an existing curriculum.
     *
     * @param int $curriculumId
     * @param array $data
     * @return Curriculum
     */
    public function updateCurriculum(int $curriculumId, array $data) {
        $curriculum = Curriculum::findOrFail($curriculumId);
        $curriculum->update($data);
        return $curriculum;
    }

    /**
     * Get a curriculum by ID.
     *
     * @param int $id
     * @return Curriculum
     */
    public function getCurriculumById(int $id) {
        return Curriculum::findOrFail($id);
    }

    /**
     * Delete a curriculum by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCurriculum(int $id) {
        $curriculum = Curriculum::findOrFail($id);
        return $curriculum->delete();
    }

    /**
     * Get all curriculums with pagination.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllCurriculums(int $sectionId) {
        return Curriculum::where('section_id', $sectionId)->orderBy('sort_order', 'asc')->get();
    }


    public function updateWatchtime(int $curriculumId, int $sectionId, int $duration) {
        $watchtime = Watchtime::where('curriculum_id', $curriculumId)->where('user_id', Auth::id())->where('section_id', $sectionId)->first();
        if($watchtime) {
            $watchtime->update(['duration' => $duration]);
        }
    }

    public function addWatchtime(int $courseId, int $curriculumId, int $sectionId, int $duration) {
        Watchtime::create([
            'course_id' => $courseId, 
            'curriculum_id' => $curriculumId, 
            'user_id' => Auth::id(), 
            'duration' => $duration, 
            'section_id' => $sectionId
        ]);
    }

    public function getWatchtime(int $curriculumId, int $sectionId) {
        return Watchtime::where('curriculum_id', $curriculumId)->where('user_id', Auth::id())->where('section_id', $sectionId)->first();
    }
}
