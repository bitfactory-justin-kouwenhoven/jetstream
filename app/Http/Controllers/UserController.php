<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")->orWhere('email', 'LIKE', "%{$value}%");
            });
        });

        $users = QueryBuilder::for(User::class)
            ->with('currentTeam')
            ->defaultSort('name')
            ->allowedSorts(['name', 'email', 'current_team_id'])
            ->allowedFilters(['name', 'email', 'current_team_id', $globalSearch])
            ->paginate()
            ->withQueryString();

        $teams = Team::pluck('name', 'id')->toArray();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ])->table(function (InertiaTable $table) {
            $table->addSearchRows([
                'name' => 'Name',
                'email' => 'Email address',
            ])
            ->addFilter('current_team_id', 'Current team', Team::pluck('name', 'id')->toArray())
            ->addColumns([
                'email' => 'Email address',
                'current_team_id' => 'Current team',
            ]);
        });
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request, CreatesNewUsers $creator)
    {
        $user = $creator->create($request->all());

        return Redirect::route('users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['person' => $user]);
    }

    public function update(User $user, Request $request, UpdatesUserProfileInformation $updator)
    {
        $user = $updator->update($user, $request->all());

        return Redirect::route('users.index')->with('message', "User '{$request->input('name')}' has been updated!");
    }

    public function show(User $user)
    {
        return Inertia::render('Users/Show', ['person' => $user]);
    }
}
