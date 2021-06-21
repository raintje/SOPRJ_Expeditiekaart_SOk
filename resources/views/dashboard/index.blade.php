@extends('layouts.app')

@section('title', 'Dashboard')

@section('head_script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"
            integrity="sha256-qoN08nWXsFH+S9CtIq99e5yzYHioRHtNB9t2qy1MSmc=" crossorigin="anonymous"></script>
@endsection

@section('content')

    <div class="pb-3">
        <h2 class="mb-4">Dashboard</h2>
        <p class="font-weight-bold">Snelle toegang</p>
        <hr>
        <a href="{{ route('users.index') }}"><button dusk="userButton" class="btn btn-primary"><i class="fa fa-user"></i>
                Gebruikersoverzicht</button></a>
        <a href="{{ route('items') }}"><button dusk="itemButton" class="btn btn-primary"><i class="fa fa-list"></i>
                Itemoverzicht</button></a>
    </div>

    <div class="row mt-5">
        <div class="w-100 col-md">
            <p class="font-weight-bold">Nieuws</p>
            <hr>
            @foreach ($itemHistories as $history)
                <div style="width: max-content" class="overflow-auto">
                    <p>
                        <b>{{ $history->performed_at->format('d-m-Y H:i') }}</b> -
                        @if ($history->message == 'Updating LayerItem ')
                            @if ($history->model() != null)
                                {{ $history->model()->title }} is aangepast door
                                {{ $history->user()->getRoleNames()->first() }} {{ $history->user()->name }}
                    </p>
                    @else
                        Item {{ $history->model_id }} is aangemaakt door {{ $history->user()->getRoleNames()->first() }}
                        {{ $history->user()->name }}</p>
                    @endif
                    @elseif($history->message == 'Deleting LayerItem ')
                        Item {{ $history->model_id }} is verwijderd door {{ $history->user()->getRoleNames()->first() }}
                        {{ $history->user()->name }}</p>
                    @endif
                    <hr>
                </div>
            @endforeach

        </div>
        <div class="col-md w-100">
            <p class="font-weight-bold">Gebruiksgegevens</p>
            <hr>
            <p class="font-weight-light">Aantal bezoekers per dag deze maand</p>
            <canvas id="this_week_vs_last"></canvas>
            <p class="font-weight-light">Meest bezochte pagina's (top 10)</p>
            <canvas id="most_visited_pages"></canvas>
        </div>
    </div>

    <script type="application/javascript">
        if (window.myChart instanceof Chart) {
            window.myChart.destroy();
        }
        var ctx = document.getElementById('this_week_vs_last').getContext('2d');
        var data = {
            labels: {!! json_encode($dates) !!},
            datasets: [
                {
                    label: "Deze maand",
                    borderColor: 'rgb(0, 123, 255)',
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    data: {!! json_encode($visitors) !!}
                },
            ]
        };
        var this_week_vs_last = new Chart(ctx, {
            type: "line",
            data: data,
        });

        var ctxVisitedPages = document.getElementById('most_visited_pages').getContext('2d');
        var dataVisitedPages = {
            labels: {!! json_encode($mostVisitedPages->pluck('pageTitle')) !!},
            datasets: [
                {
                    label: "Deze maand",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    fillColor: "rgba(0, 123, 255)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#007bff",
                    pointHighlightFill: "#007bff",
                    data: {!! json_encode($mostVisitedPages->pluck('pageViews')) !!}
                },
            ]
        };
        var most_visited_pages = new Chart(ctxVisitedPages, {
            type: "bar",
            data: dataVisitedPages,
        });

    </script>

@endsection

@section('script')

@endsection
