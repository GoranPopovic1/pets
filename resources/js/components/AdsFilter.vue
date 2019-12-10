<template>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card-header">Filter</div>

            <div class="card-body">
                <div class="row">
                    <form method="POST" action="javascript:void(0)" @submit.prevent="filterAds">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <!--                            @php
                                                            $categories = ['Psi', 'Mačke', 'Ptice', 'Konji', 'Ribice', 'Glodari', 'Reptili i amfibije', 'Ostalo'];
                                                            @endphp
                                                            @foreach( $categories as $cat )
                                                            <input type="checkbox" id="category-1" name="category[]" value="{{ strtolower(str_replace(' ', '', $cat)) }}" /> {{ __($cat) }}<br/>
                                                            @endforeach-->
                                <div class="checkbox-holder mb-2" v-for="ad_category in ads_categories">
                                    <input type="checkbox" name="category[]" :value="ad_category | formatCategory()" />{{ ad_category }}<br/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">Pol</label>
                            <select id="sex" class="form-control" name="sex" autocomplete="category" autofocus>
                                <option value="">Izaberi</option>
                                <option value="muški">Muški</option>
                                <option value="ženski">Ženski</option>
                                <option value="oba">Oba Pola</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <input id="search" type="text" placeholder="Pretraži oglase" class="form-control" name="search" autocomplete="search">
                        </div>

                        <div class="form-group row mb-0">
                            <button type="submit" class="btn btn-primary">Pretraga</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!--@foreach($ads as $ad)-->
            <div class="card mb-2">
                <div class="card-header"><a href="#">tekst</a></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!--@foreach($ad->images as $image)-->
                            <img src="" alt="ad-image" style="height: 100px;" />
                            <!--@break-->
                            <!--@endforeach-->
                            <p class="card-text">Opis: </p>
                            <p class="card-text">Pol: </p>
                            <p class="card-text">Datum: </p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Mesto/Grad: </p>
                        </div>
                    </div>
                </div>
            </div>
            <!--@endforeach-->
        </div>
    </div>
</template>

<script>
    export default {
        /*props: ['ads'],*/
        name: "AdsFilter",
        mounted() {
            console.log('Component mounted.');
            /*console.log(JSON.parse(this.ads));*/
        },
        data() {
            return {
                ads_categories: ['Psi', 'Mačke', 'Ptice', 'Konji', 'Ribice', 'Glodari', 'Reptili i amfibije', 'Ostalo'],
                ads_data: [],
                ad_data: {
                    id: '',
                    title: '',
                    description: '',
                    category: '',
                    sex: '',
                    images: [],
                    user: {},
                    user_id: '',
                    created_at: '',
                    updated_at: ''
                }
            }
        },
        created() {
            /*            this.ads_data = JSON.parse(this.ads);
                        console.log(this.ads_data);*/
        },
        methods: {
            filterAds() {
                this.article.user_id = this.$root.$data.user_id;
                this.article.comments_count = 0;

                let formData = new FormData();
                formData.append('id', this.article.id);
                fetch('search', {
                    method: 'POST',
                    body: formData,
                })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        alert('Article Added');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));

            },
            /*            handleSorting(event){
                            if(event.target.value == 'asc') {
                                this.ads_data.sort((a, b) => {
                                    return new Date(a.created_at) - new Date(b.created_at);
                                });
                            } else {
                                this.ads_data.sort((a, b) => {
                                    return new Date(b.created_at) - new Date(a.created_at);
                                });
                            }

                            return this.ads_data;
                        }*/
        },
        filters: {
            formatCategory: function (category) {
                return category.replace(/ /g, "").toLowerCase();
            }
        }
    }
</script>