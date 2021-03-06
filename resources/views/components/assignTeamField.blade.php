@php if (! isset($team)) $team = new App\Team; @endphp
<tr>
    <td>{{ __('team.team') }}:</td>
    @can("assignToTeam", new App\Ticket)
        <td>{{ Form::select('team_id', createSelectArray( App\Team::all(),true), $team->id) }}
    @else
        <td>{{ Form::select('team_id', createSelectArray( auth()->user()->teams,false), $team->id) }}
    @endcan
</td>