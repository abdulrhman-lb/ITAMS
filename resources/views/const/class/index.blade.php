@extends('layouts.app')

@section('content')
@if (session()->has('message'))
    <div class="container alert alert-warning" role="alert">
        {{session()->get('message')}}
    </div> 
@endif
    <div class="container">
        <h5 class="d-flex fw-bold justify-content-center pb-3">قائمة التصنيفات </h5>
        <table class="table table-bordered">
            <tr>
                <th class="centered-content">#</th>
                <th class="centered-content">التصنيفات وتعني الأصول - الملحقات - التراخيص .... الخ</th>
                <th class="centered-content" colspan="2"><a href="/const/class/create"><button type="button" class="btn btn-dark my-1">إضافة جديدة  <i class="fa fa-plus-square"></i></button></a></th>	
            </tr>
            @php
                $count = 0;
            @endphp
            @foreach ($classes as $class)        
                <tr class="pt-3 ">
                    @php
                        $count++;
                    @endphp
                    <td class="fw-bold centered-content">{{$count}}</td>
                    <td class="centered-content">{{$class -> class}}</td>
                    <td class="centered-content">
                        {{-- action="{{action('CalssController@destroy', $class -> id)}}" --}}
                        <form action="/const/class/{{$class -> id}}" method="POST">   
                            @csrf
                            @method("DELETE")
                            <a href="/const/class/{{$class -> id}}/edit"><button type="button" class="btn btn-secondary my-1"><i class="fa fa-edit"></i></button></a>
                            <button type="submit" class="btn btn-secondary my-1" onclick ="return confirm('هل تريد بالتأكيد حذف هذا التصنيف ؟')"><i class="fa fa-trash"></i></button>  
                        </form>  
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection