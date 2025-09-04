<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with(
            [
                'address.country',
                'roles',
                'identityVerification' => function ($query) {
                    $query->select('id', 'user_id', 'parent_verified_at');
                }
            ]
        )
            ->whereHas('roles', function ($query) {
                $query->whereNotIn('roles.name', ['admin', 'sub_admin']);
            })
            ->withWhereHas('profile', function ($query) {
                $query->select('id', 'user_id', 'first_name', 'last_name', 'slug', 'image', 'recommend_tutor', 'verified_at', 'phone_number');
            })
            ->orderBy('id', 'asc')
            ->get();
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->profile?->full_name,
            $user->email,
            $user->profile?->phone_number,
            $user->created_at->format('F d, Y'),
            ucfirst($user->default_role),
            $user->email_verified_at ? "Verified" : "Non Verified",
            $user->status,
            $user->address?->country?->name,
            $user->profile?->verified_at ? "Verified" : "Non Verified",
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Created At',
            'Role',
            'Email Verified',
            'Status',
            'Country',
            'Identity Verification'
        ];
    }
}
