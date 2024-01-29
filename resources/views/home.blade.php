@extends('layouts.app')

@section('content')
    <form action="{{route('addPost')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Title</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="title" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Text</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="text" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <h1>From database</h1>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Text</th>
                            <th scope="col">User_id</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{ $record->title }}</td>
                                <td>{{ $record->text }}</td>
                                <td>{{ $record->user_id }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script type="module">
        Echo.channel(`notifications`)
            .listen('.RatingIncreased', function(event) {
                console.log('Рейтинг повышен для пользователя ' + event);
            });
    </script>
@endsection
