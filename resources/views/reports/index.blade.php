@extends('layouts.app')
@section('content')
    <div class="description">
        <h3>Reports</h3>
    </div>

    <div class="description">
        {{ Form::open( ["url" => route('reports.index'), 'method' => 'GET'] ) }}
        {{ Form::date('startDate',  $repository->startDate) }}
        {{ Form::date('endDate',    $repository->endDate) }}
        <button class="ph4 uppercase"> @icon(filter) {{ __('report.filter') }}</button>
        {{ Form::close() }}
    </div>

    <table class="striped">
        <thead>
            <tr>
                <th></th>
                <th> {{ trans_choice('ticket.ticket',2) }}      </th>
                <th> {{ trans_choice('ticket.unanswered',2) }}  </th>
                <th> {{ trans_choice('ticket.open',2) }}        </th>
                <th> {{ trans_choice('ticket.solved',2) }}      </th>
                <th> {{ __('report.firstReplyTime') }}          </th>
                <th> {{ __('report.solveTime') }}               </th>
                <th> {{ __('report.onTouchResolutionRatio') }}  </th>
                <th> {{ __('report.reopenedRatio') }}           </th>
            </tr>
        </thead>
        <tr>
            <td> You </td>
            <td>  {{ $repository->tickets( auth()->user() ) }}   </td>
            <td>  {{ $repository->unansweredTickets( auth()->user() ) }}   </td>
            <td>  {{ $repository->openTickets( auth()->user() ) }}   </td>
            <td>  {{ $repository->solvedTickets( auth()->user() ) }}   </td>
            <td>
                {{ $repository->firstReplyKpi(auth()->user()) }}
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_FIRST_REPLY, auth()->user())  ])
            </td>
            <td>
                {{ $repository->solveKpi(auth()->user()) }}
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_SOLVED, auth()->user()) ])
            </td>
            <td>
                {{ $repository->oneTouchResolutionKpi( auth()->user() ) }} %
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_ONE_TOUCH_RESOLUTION, auth()->user()) ])
            </td>
            <td>
                {{ $repository->reopenedKpi( auth()->user() ) }} %
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_REOPENED, auth()->user()) ])
            </td>
        </tr>
        @foreach(auth()->user()->teams as $team)
        <tr>
            <td> {{ $team->name }} </td>
            <td>  {{ $repository->tickets( $team ) }}   </td>
            <td>  {{ $repository->unansweredTickets( $team ) }}   </td>
            <td>  {{ $repository->openTickets( $team ) }}   </td>
            <td>  {{ $repository->solvedTickets( $team ) }}   </td>

            <td>
                {{ $repository->firstReplyKpi(auth()->user()) }}
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_FIRST_REPLY, auth()->user())  ])
            </td>
            <td>
                {{ $repository->solveKpi($team) }}
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_SOLVED, $team) ])
            </td>
            <td>
                {{ $repository->oneTouchResolutionKpi( $team ) }} %
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_ONE_TOUCH_RESOLUTION, $team) ])
            </td>
            <td>
                {{ $repository->reopenedKpi( $team ) }} %
                @include('components.increment',["value" => $repository->average(App\Kpi\Kpi::KPI_REOPENED, $team) ])
            </td>
        </tr>
        @endforeach
        <tr>
            <td> All </td>
            <td>  @if(auth()->user()->admin ){{ $repository->tickets( ) }}  @endif </td>
            <td>  @if(auth()->user()->admin ){{ $repository->unansweredTickets( ) }}  @endif </td>
            <td>  @if(auth()->user()->admin ){{ $repository->openTickets( ) }}  @endif </td>
            <td>  @if(auth()->user()->admin ){{ $repository->solvedTickets( ) }}  @endif </td>
            <td>  {{$repository->firstReplyKpi() }}</td>
            <td>  {{ $repository->solveKpi() }}     </td>
            <td>  {{ $repository->oneTouchResolutionKpi( ) }} %        </td>
            <td>  {{ $repository->reopenedKpi(  ) }} %        </td>
        </tr>
    </table>

@endsection
