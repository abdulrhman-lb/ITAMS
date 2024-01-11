@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة جهاز جديد</div>
                <div class="card-body">
                    <form method="POST" action="/device">
                        @csrf
                        <div class="row mb-3">
                            <label for="branch_id" class="col-md-4 col-form-label text-md-end">اختر الفرع</label>
                            <div class="col-md-6">
                                <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                    <option value="">-</option>
                                    @foreach ($list['branches'] as $branch)
                                    <option value="{{$branch -> id}}" {{ $branch -> id == old('branch_id') ? 'selected' : ''}}>{{$branch -> branch}}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="class_id" class="col-md-4 col-form-label text-md-end">اختر التصنيف</label>
                            <div class="col-md-6">
                                <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id">
                                    <option value="">-</option>
                                    @foreach ($list['classes'] as $class)
                                        <option value="{{$class -> id}}" {{ $class -> id == old('class_id') ? 'selected' : ''}}>{{$class -> class  }}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">اختر الصنف</label>
                            <div class="col-md-6">
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="model_id" class="col-md-4 col-form-label text-md-end">اختر الموديل</label>
                            <div class="col-md-6">
                                <select class="form-select @error('model_id') is-invalid @enderror" id="model_id" name="model_id">
                                </select>
                                @error('model_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="serial_number" class="col-md-4 col-form-label text-md-end">الرقم المتسلسل</label>
                            <div class="col-md-6">
                                <input id="serial_number" type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" value="{{ old('serial_number') }}">
                                @error('serial_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status_id" class="col-md-4 col-form-label text-md-end">اختر الحالة الفنية</label>
                            <div class="col-md-6">
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id">
                                    <option value="">-</option>
                                    @foreach ($list['statuses'] as $status)
                                        <option value="{{$status -> id}}" {{ $status -> id == old('status_id') ? 'selected' : ''}}>{{$status -> status  }}</option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="accossories" class="col-md-4 col-form-label text-md-end">الملحقات</label>
                            <div class="col-md-6">
                                <input id="accossories" type="text" class="form-control @error('accossories') is-invalid @enderror" name="accossories" value="{{ old('accossories') }}">
                                @error('accossories')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="notes" class="col-md-4 col-form-label text-md-end">ملاحظات</label>
                            <div class="col-md-6">
                                <input id="notes" type="text" class="form-control @error('notes') is-invalid @enderror" name="notes" value="{{ old('notes') }}">
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-6 col-form-label text-md-end">معلومات خاصة بأجهزة الحواسب المحمولة والمكتبية</label>
                        </div>

                        <div class="row mb-3">
                            <label for="processor_id" class="col-md-4 col-form-label text-md-end">اختر المعالج</label>
                            <div class="col-md-6">
                                <select class="form-select @error('processor_id') is-invalid @enderror" id="processor_id" name="processor_id">
                                    <option value="">-</option>
                                    @foreach ($list['processors'] as $processor)
                                        <option value="{{$processor -> id}}" {{ $processor -> id == old('processor_id') ? 'selected' : ''}}>{{$processor -> processor  }}</option>
                                    @endforeach
                                </select>
                                @error('processor_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="memory1_id" class="col-md-4 col-form-label text-md-end">اختر الذاكرة 1</label>
                            <div class="col-md-6">
                                <select class="form-select @error('memory1_id') is-invalid @enderror" id="memory1_id" name="memory1_id">
                                    <option value="">-</option>
                                    @foreach ($list['memories'] as $memory)
                                        <option value="{{$memory -> id}}" {{ $memory -> id == old('memory1_id') ? 'selected' : ''}}>{{$memory -> kind . ' - ' . $memory -> size . ' GB'}}</option>
                                    @endforeach
                                </select>
                                @error('memory1_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="memory2_id" class="col-md-4 col-form-label text-md-end">اختر الذاكرة 2</label>
                            <div class="col-md-6">
                                <select class="form-select @error('memory2_id') is-invalid @enderror" id="memory2_id" name="memory2_id">
                                    <option value="">-</option>
                                    @foreach ($list['memories'] as $memory)
                                        <option value="{{$memory -> id}}" {{ $memory -> id == old('memory2_id') ? 'selected' : ''}}>{{$memory -> kind . ' - ' . $memory -> size . ' GB'}}</option>
                                    @endforeach
                                </select>
                                @error('memory2_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hard_disk1_id" class="col-md-4 col-form-label text-md-end">اختر الهارد 1</label>
                            <div class="col-md-6">
                                <select class="form-select @error('hard_disk1_id') is-invalid @enderror" id="hard_disk1_id" name="hard_disk1_id">
                                    <option value="">-</option>
                                    @foreach ($list['hard_disks'] as $hard_disk)
                                        <option value="{{$hard_disk -> id}}" {{ $hard_disk -> id == old('hard_disk1_id') ? 'selected' : ''}}>{{$hard_disk -> kind . ' - ' . $hard_disk -> size . ' GB'}}</option>
                                    @endforeach
                                </select>
                                @error('hard_disk1_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="hard_disk2_id" class="col-md-4 col-form-label text-md-end">اختر الهارد 2</label>
                            <div class="col-md-6">
                                <select class="form-select @error('hard_disk2_id') is-invalid @enderror" id="hard_disk2_id" name="hard_disk2_id">
                                    <option value="">-</option>
                                    @foreach ($list['hard_disks'] as $hard_disk)
                                        <option value="{{$hard_disk -> id}}" {{ $hard_disk -> id == old('hard_disk2_id') ? 'selected' : ''}}>{{$hard_disk -> kind . ' - ' . $hard_disk -> size . ' GB'}}</option>
                                    @endforeach
                                </select>
                                @error('hard_disk2_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">إضافة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection