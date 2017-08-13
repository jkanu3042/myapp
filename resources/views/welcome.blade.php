@extends('layouts.master')



@section('content')
    <ul>
    @forelse($items as $item)
        <li>{{$item}}</li>
    @empty
        <li>아무것도 없어요.</li>
        @endforelse
    </ul>

    @include('partials.footer')
@endsection

@section('script')
    <script>
        alert("저는 자식뷰의 'script' 섹션입니다. "    );
    </script>
@endsection


