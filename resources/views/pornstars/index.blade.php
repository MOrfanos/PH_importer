@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="pornstars" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>License</th>
                                    <th>wlStatus</th>
                                    <th>Link</th>
                                    <th>Aliases</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="pornstars-list">
                            </tbody>
                        </table>
                        <button id="load-more" class="btn btn-success">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let page = 1;
            let perPage = 10;
            let isLoading = false;

            function loadPornstars() {
                isLoading = true;
                $.ajax({
                    url: '/api/pornstars',
                    type: 'GET',
                    data: { page: page, per_page: perPage },
                    success: function (response) {
                        let html = '';
                        response.data.forEach(function (item) {
                            html += '<tr>'
                                + '<td>' + item.id + '</td>'
                                + '<td>' + item.name + '</td>'
                                + '<td>' + item.license + '</td>'
                                + '<td>' + item.wlStatus + '</td>'
                                + '<td>' + item.link + '</td>'
                                + '<td>' + item.aliases + '</td>'
                                + '<td><a href="/pornstars/' + item.id + '/profile" class="btn btn-info">Profile</a></td>'
                                + '</tr>'
                        });

                        $('#pornstars-list').append(html);

                        if (response.meta.current_page < response.meta.last_page) {
                            $('#load-more').show();
                            page++;
                        } else {
                            $('#load-more').hide();
                        }

                        isLoading = false;
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading more pornstars:', error);
                        isLoading = false;
                    }
                });
            }

            loadPornstars();

            $('#load-more').click(function () {
                if (!isLoading) {
                    loadPornstars();
                }
            });
        });
    </script>
@endpush
