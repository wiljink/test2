@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resolved Concerns</h1>

        @if(isset($message))
            <div class="alert alert-warning">
                {{ $message }}
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Resolved Date</th>
                        <th>Resolution Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        @php
                            $average = json_decode($post->resolved_days, true);
                            dd($average);
                        @endphp
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($post->resolved_date)->format('Y-m-d H:i:s') }}</td>
                            <td>
                                @if($average)
                                    {{ $average['Days'] ?? 0 }} Days, 
                                    {{ $average['Hours'] ?? 0 }} Hours, 
                                    {{ $average['Minutes'] ?? 0 }} Minutes, 
                                    {{ $average['Seconds'] ?? 0 }} Seconds
                                @else
                                    No resolution time available
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Average Resolution Time</h3>
            <p>
                <strong>{{ $average['days'] }} Days, </strong>
                <strong>{{ $average['hours'] }} Hours, </strong>
                <strong>{{ $average['minutes'] }} Minutes, </strong>
                <strong>{{ $average['seconds'] }} Seconds</strong>
            </p>
        @endif
    </div>
@endsection
