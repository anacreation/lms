<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Lms\Models\Curriculum;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserCurriculaController extends Controller
{
    public function index(User $user): View {
        $curricula = Curriculum::all();
        $user->load('curricula');

        return view('lms::admin.users.curricula.index',
            compact("curricula", "user"));
    }

    public function store(User $user, Request $request) {
        $validatedData = $this->validate($request, [
            'ids.*' => "in:" . implode(",",
                    Curriculum::pluck('id')->toArray())
        ]);

        $this->updateUserCurricula($user, $validatedData);

        return redirect()->route('users.index')
                         ->withStatus("{$user->name}'s learning curricula has been updated!");
    }

    private function getSyncIndices(array $newIds, array $oldIds) {
        $addIds = [];
        $removeIds = [];

        foreach ($newIds as $newId) {
            if (!in_array($newId, $oldIds)) {
                $addIds[] = $newId;
            }
        }
        foreach ($oldIds as $oldId) {
            if (!in_array($oldId, $newIds)) {
                $removeIds[] = $newId;
            }
        }

        return [$addIds, $removeIds];
    }

    /**
     * @param \App\User $user
     * @param           $validatedData
     */
    private function updateUserCurricula(User $user, $validatedData): void {
        if (isset($validatedData['ids'])) {
            list($addIds, $removeIds) = $this->getSyncIndices($validatedData['ids'],
                $user->getAssignedCurricula()->pluck('id')->toArray());
            foreach ($addIds as $curriculumId) {
                $user->assignCurriculum(Curriculum::find($curriculumId));
            }
            foreach ($removeIds as $curriculumId) {
                $user->removeCurriculum(Curriculum::find($curriculumId));
            }
        } else {
            foreach ($user->getAssignedCurricula()->pluck('id')
                          ->toArray() as $curriculumId) {
                $user->removeCurriculum(Curriculum::find($curriculumId));
            }
        }
    }
}
