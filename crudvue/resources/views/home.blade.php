@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="colsm-12">
                <h3>Usuarios</h3>
                <div id="usuarios">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="item in items">
                            <a href="#">
                                @{{ item.name }}
                            </a>
                        </li>
                    </ul>
                    <nav>
                        <ul class="pagination">
                            <li v-if="pagination.current_page > 1">
                                <a href="#" aria-label="Previous"
                                   @click.prevent="changePage(pagination.current_page - 1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li v-for="page in pagesNumber"
                                v-bind:class="[ page == isActived ? 'active' : '']">
                                <a href="#"
                                   @click.prevent="changePage(page)">@{{ page }}</a>
                            </li>
                            <li v-if="pagination.current_page < pagination.last_page">
                                <a href="#" aria-label="Next"
                                   @click.prevent="changePage(pagination.current_page + 1)">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        new Vue({
            el: '#usuarios',
            data: {
                pagination: {
                    total: 0,
                    per_page: 7,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,// left and right padding from the pagination <span>,just change it to see effects
                items: []
            },
            ready: function () {
                this.fetchItems(this.pagination.current_page);
            },
            computed: {
                isActived: function () {
                    return this.pagination.current_page;
                },
                pagesNumber: function () {
                    if (!this.pagination.to) {
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
                    if (to >= this.pagination.last_page) {
                        to = this.pagination.last_page;
                    }
                    var pagesArray = [];
                    while (from <= to) {
                        pagesArray.push(from);
                        from++;
                    }

                    return pagesArray;
                }
            },
            methods: {
                fetchItems: function (page) {
                    var data = {page: page};
                    this.$http.get('api/users', data).then(function (response) {
                        //look into the routes file and format your response
                        this.$set('items', response.data.data.data);
                        this.$set('pagination', response.data.pagination);
                    }, function (error) {
                        // handle error
                    });
                },
                changePage: function (page) {
                    this.pagination.current_page = page;
                    this.fetchItems(page);
                }
            }
        });
    </script>
@endsection
