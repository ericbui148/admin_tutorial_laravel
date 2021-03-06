@extends('layouts.app')

@section('page-title', __('Trạng thái sale'))
@section('page-heading', __('Trạng thái sale'))

@section('breadcrumbs')
    <li class="breadcrumb-item text-muted">
        @lang('Cài đặt')
    </li>
    <li class="breadcrumb-item active">
        @lang('Trạng thái sale')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="card">
        <div class="card-body">
            <form action="" method="GET" class="pb-2 mb-3 border-bottom-light">
                <div class="row my-3 flex-md-row flex-column-reverse">
                    <div class="col-md-4 mt-md-0 mt-2">
                        <div class="input-group custom-search-form">
                            <input type="text"
                                   class="form-control input-solid"
                                   name="search"
                                   value="{{ Request::get('search') }}"
                                   placeholder="@lang('Search for sale-stages...')">

                            <span class="input-group-append">
                                <button class="btn btn-light" type="submit" id="search-users-btn">
                                    <i class="fas fa-search text-muted"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <a href="{{ route('sale-stages.create') }}" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            @lang('Thêm trạng thái sale')
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="min-width-100">@lang('Tên')</th>
                        <th class="min-width-100">@lang('Mã')</th>
                        <th class="text-center">@lang('Hành động')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($saleStages))
                            @foreach ($saleStages as $saleStage)
                                <tr>
                                    <td>{{ $saleStage->name }}</td>
                                    <td>{{ $saleStage->code }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('sale-stages.edit', $saleStage) }}" class="btn btn-icon"
                                           title="@lang('Edit Industry')" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('sale-stages.destroy', $saleStage) }}" class="btn btn-icon"
                                           title="@lang('Delete Industry')"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           data-method="DELETE"
                                           data-confirm-title="@lang('Please Confirm')"
                                           data-confirm-text="@lang('Are you sure that you want to delete this industry?')"
                                           data-confirm-delete="@lang('Yes, delete it!')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"><em>@lang('Không tìm thấy bản ghi.')</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! $saleStages->render() !!}
@stop
