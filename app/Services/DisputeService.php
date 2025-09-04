<?php

namespace App\Services;

use App\Models\User;
use App\Models\Dispute;
use App\Models\DisputeConversation;
use App\Casts\DisputeStatus;
use App\Casts\ConversationGroup;
use Illuminate\Support\Facades\Auth;

class DisputeService {

    public $user;
    public function __construct($user) {
        $this->user = $user;
    }

    public function createDispute($data) {
        return Dispute::create($data);
    }

    public function getUserChat($disputeId, $role)
    {
        if($role == 'student') {
            return $this->getAdminStudentChat($disputeId);
        } else {
            return $this->getAdminTutorChat($disputeId);
        }
    }

    public function getAdminStudentChat($disputeId)
    {
        $dispute = Dispute::findOrFail($disputeId);
        $adminStudentChat = DisputeConversation::where('dispute_id', $disputeId)
        ->where('conversation_group', ConversationGroup::$groups['student'])
        ->with(['user' => function($query) {
            $query->select('id','email')->with(['profile' => function($subQuery) {
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->orderBy('created_at')
        ->get();
        return $adminStudentChat;
    }
    
    public function getAdminTutorChat($disputeId)
    {
        $dispute = Dispute::findOrFail($disputeId);
        $adminTutorChat = DisputeConversation::where('dispute_id', $disputeId)
            ->where('conversation_group', ConversationGroup::$groups['tutor'])
            ->with(['user' => function($query) {
                $query->select('id','email')->with(['profile' => function($subQuery) {
                    $subQuery->select('id','user_id','first_name','last_name','image');
                }]);
            }])
            ->orderBy('created_at')
            ->get();
        return $adminTutorChat;
    }

    public function sendMessage($disputeId, $message, $role) {
        DisputeConversation::create([
            'dispute_id' => $disputeId,
            'user_id' => $this->user->id,
            'message' => $message,
            'conversation_group' => $role == 'student' ? ConversationGroup::$groups['student'] : ConversationGroup::$groups['tutor'],
        ]);
    }
    
    public function getDisputes($keyword = '', $perPage = 10, $status = '', $sortBy = '') {
        if($this->user->role == 'tutor') {
            return $this->getResponsibleDisputes($keyword, $perPage, $status, $sortBy);
        } else {
            return $this->getCreatedDisputes($keyword, $perPage, $status, $sortBy);
        }
    }

    public function getResponsibleDisputes($keyword = '', $perPage = 10, $status = '', $sortBy = '') {
        $disputes = Dispute::where('responsible_by', $this->user->id)->where('status', '!=', DisputeStatus::$statuses['pending'])->where('status', '!=', DisputeStatus::$statuses['under_review'])
        ->with(['creatorBy' => function($query){
            $query->select('id','email')->with(['profile' => function($subQuery){
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->with(['disputeConversations' => function($query) {
            $query->where('conversation_group', ConversationGroup::$groups['tutor']);
        }])
        ->with(['booking' => function($query) {
            $query->with(['slot' => function($subQuery) {
                $subQuery->with(['subjectGroupSubjects' => function($subSubQuery) {
                    $subSubQuery->with('subject', 'group');
                }]);
            }]);
        }])
        ->when($keyword, function($query) use ($keyword) {
            $query->where('dispute_reason', $keyword);
        })
        ->when($status, function($query) use ($status) {
            $query->where('status', DisputeStatus::$statuses[$status]);
        })
        ->when($sortBy, function($query) use ($sortBy) {
            $query->orderBy('created_at', $sortBy);
        })
        ->paginate($perPage);
        return $disputes;
    }

    public function getCreatedDisputes($keyword = '', $perPage = 10, $status = '', $sortBy = '') {
        
        $disputes = Dispute::where('creator_by', $this->user->id)
        ->with(['responsibleBy' => function($query){
            $query->select('id','email')->with(['profile' => function($subQuery){
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->with(['disputeConversations' => function($query) {
            $query->where('conversation_group', ConversationGroup::$groups['student']);
        }])
        ->with(['booking' => function($query) {
            $query->with(['slot' => function($subQuery) {
                $subQuery->with(['subjectGroupSubjects' => function($subSubQuery) {
                    $subSubQuery->with('subject', 'group');
                }]);
            }]);
        }])
        ->when($keyword, function($query) use ($keyword) {
            $query->where('dispute_reason', $keyword);
        })
        ->when($status, function($query) use ($status) {
            $query->where('status', DisputeStatus::$statuses[$status]);
        })
        ->when($sortBy, function($query) use ($sortBy) {
            $query->orderBy('created_at', $sortBy);
        })
        ->paginate($perPage);
        return $disputes;
    }


    public function getAllDisputes($keyword = '', $perPage = 10, $status = '', $sortby = '') {
        $disputes = Dispute::with(['creatorBy' => function($query){
            $query->select('id','email')->with(['profile' => function($subQuery){
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->with(['responsibleBy' => function($query){
            $query->select('id','email')->with(['profile' => function($subQuery){
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->with(['booking' => function($query) {
            $query->with(['slot' => function($subQuery) {
                $subQuery->with(['subjectGroupSubjects' => function($subSubQuery) {
                    $subSubQuery->with('subject', 'group');
                }]);
            }]);
        }])
        ->when($keyword, function($query) use ($keyword) {
            $query->where('dispute_reason', $keyword);
        })
        ->when($status, function($query) use ($status) {
            $query->where('status', DisputeStatus::$statuses[$status]);
        })
        ->when($sortby, function($query) use ($sortby) {
            $query->orderBy('created_at', $sortby);
        })
        ->paginate($perPage);
        return $disputes;
    }


    public function getDisputeByID($disputeId) {
        
        $disputes = Dispute::where('id', $disputeId)
        ->with(['creatorBy' => function($query){
            $query->select('id','email')->with(['profile' => function($subQuery){
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->with(['responsibleBy' => function($query){
            $query->select('id','email')->with(['profile' => function($subQuery){
                $subQuery->select('id','user_id','first_name','last_name','image');
            }]);
        }])
        ->with(['booking' => function($query) {
            $query->with(['slot' => function($subQuery) {
                $subQuery->with(['subjectGroupSubjects' => function($subSubQuery) {
                    $subSubQuery->with('subject', 'group');
                }]);
            }]);
        }])
        ->first();
        return $disputes;
    }
    public function changeStatus($disputeId, $newStatus) {
        $dispute = Dispute::find($disputeId);
        $dispute->status = DisputeStatus::$statuses[$newStatus];
        $dispute->save();
        return $dispute;
    }
    
    public function getDisputeId($uuid) {
        $dispute = Dispute::where('uuid', $uuid)->first();
        return $dispute?->id;
    }

    public function addWinnerId($disputeId, $winnerId) {
        $dispute = Dispute::find($disputeId);
        $dispute->winner_id = $winnerId;
        $dispute->save();
    }
}
