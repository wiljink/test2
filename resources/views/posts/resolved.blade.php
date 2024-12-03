
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
                            $resolvedTime = json_decode($post->resolved_days, true);
                        @endphp
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($post->resolved_date)->format('Y-m-d H:i:s') }}</td>
                            <td>
                                @if($resolvedTime)
                                    {{ $resolvedTime['Days'] ?? 0 }} Days,
                                    {{ $resolvedTime['Hours'] ?? 0 }} Hours, 
                                    {{ $resolvedTime['Minutes'] ?? 0 }} Minutes, 
                                    {{ $resolvedTime['Seconds'] ?? 0 }} Seconds
                                @else
                                    No resolution time available
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if(isset($average))
                <h3>Average Resolution Time</h3>
                <p>
                    <strong>{{ $average['days'] ?? 0 }} Days, </strong>
                    <strong>{{ $average['hours'] ?? 0 }} Hours, </strong>
                    <strong>{{ $average['minutes'] ?? 0 }} Minutes, </strong>
                    <strong>{{ $average['seconds'] ?? 0 }} Seconds</strong>
                </p>
            @else
                <p>No average resolution time available.</p>
            @endif
        @endif
    </div>
