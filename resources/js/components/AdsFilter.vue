<template>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="javascript:void(0)">

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Kategorija</label>
                            <select v-model="selected_category" id="category" class="form-control" name="category" @change="fetchSearchResults($event)">
                                <option value="">Izaberi</option>
                                <option v-for="ad_category in ads_categories" :value="ad_category.id">
                                    {{ ad_category.name }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">Pol</label>
                            <select v-model="selected_sex" id="sex" class="form-control" name="sex" @change="fetchSearchResults($event)">
                                <option value="">Izaberi</option>
                                <option v-for="ad_sex in ads_sexes" :value="ad_sex.id">
                                    {{ ad_sex.name }}
                                </option>
                            </select>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <form action="javascript:void(0)">
                        <div class="form-group">
                            <label for="sort" class="col-form-label text-md-right d-inline-block align-middle">Sortiraj po:</label>
                            <select id="sort"
                                    class="form-control d-inline-block align-middle"
                                    name="sort" autocomplete="sort" autofocus v-model="selected_sorting_rule" @change="fetchSearchResults($event, null)">
                                <option value="">najnovijem</option>
                                <option value="date-asc">najstarijem</option>
                                <option value="name-asc">nazivu A - Ž</option>
                                <option value="name-desc">nazivu Ž - A</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-2" v-for="ad_data in ads_data">
                <div class="card-header"><a :href="'ads/' + ad_data.id">{{ ad_data.title }}</a></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img :src="ad_data.images[0].image_path" alt="ad-image" style="height: 100px;" /> <!-- to do: check if image exists -->
                            <p class="card-text">Opis: {{ ad_data.description }}</p>
                            <p class="card-text">Pol: {{ ad_data.sex.name }}</p>
                            <p class="card-text">Datum: {{ ad_data.created_at | moment("D.M.YYYY") }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">Mesto/Grad: {{ ad_data.user.city }}</p>
                        </div>
                    </div>
                    <div>
                        <a class="btn btn-secondary" :href="'ads/' + ad_data.id + '/edit'">Izmeni oglas</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card-header">Pretraga</div>
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="javascript:void(0)">
                        <div class="form-group row">
                            <input v-model="search_term" id="search-term" type="text" placeholder="Pretraži oglase" class="form-control" name="search-term" autocomplete="search">
                        </div>

                        <div class="form-group row mb-0">
                            <button id="search-button" type="submit" class="btn btn-primary" @click="fetchSearchResults($event, null)">Pretraga</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <nav class="mt-5">
            <ul class="pagination">
                <li :class="[{disabled: !ads_paginator_data.prev_page_url}, 'page-item']">
                    <a href="#" class="page-link" aria-label="Previous" @click.prevent="fetchSearchResults(ads_paginator_data.prev_page_url, '')">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="n in ads_paginator_data.last_page" :class="[{active: n===ads_paginator_data.current_page}, 'page-item']">
                    <a href="#" class="page-link" @click.prevent="fetchSearchResults($event, n)">{{ n }}
                        <span class="sr-only"></span>
                    </a>
                </li>
                <li :class="[{disabled: !ads_paginator_data.next_page_url}, 'page-item']">
                    <a href="#" class="page-link" aria-label="Next" @click.prevent="fetchSearchResults(ads_paginator_data.next_page_url, '')">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        // props: ['ads', 'categories', 'sexes'],
        name: 'AdsFilter',
        mounted() {
            console.log('Component mounted.');
            // console.log(JSON.parse(this.ads));
        },
        data() {
            return {
                ads_categories: [],
                ads_sexes: [],
                ads_paginator_data: {},
                ads_data: [],
                selected_category: '',
                selected_sex: '',
                selected_sorting_rule: '',
                search_term: '',
                pagination: {}
            }
        },
        created() {
            // this.ads_paginator_data = JSON.parse(this.ads);
            // this.ads_data = this.ads_paginator_data.data;
            // this.ads_categories = JSON.parse(this.categories);
            // this.ads_sex = JSON.parse(this.sexes);
            this.fetchSearchResults();
            // console.log(this.ads_data);
        },
        methods: {
            fetchSearchResults(event, n = null) {
                let queryParams = window.location.search,
                    pageUrl = 'search/results' + queryParams,
                    newPageUrl = pageUrl, // if n == null
                    modifiedNewPageUrl;

                if(typeof event !== 'undefined') {
                    console.log(event);
                    if(event.target.name === 'sort' || event.target.name === 'category' || event.target.name === 'sex' || event.target.id === 'search-button') {
                        if (event.target.name === 'sort') {
                            queryParams = this.removeAddParameter(queryParams, 'sort', this.selected_sorting_rule);
                        }
                        if (event.target.name === 'category') {
                            queryParams = this.removeAddParameter(queryParams, 'category', this.selected_category);
                        }
                        if (event.target.name === 'sex') {
                            queryParams = this.removeAddParameter(queryParams, 'sex', this.selected_sex);
                        }
                        if (event.target.id === 'search-button') {
                            queryParams = this.removeAddParameter(queryParams, 'search-term', this.search_term);
                        }

                        pageUrl = 'search/results' + queryParams;
                        newPageUrl = this.removeAddParameter(pageUrl, 'page', 1);
                        modifiedNewPageUrl = newPageUrl.replace('/results', '');
                        history.pushState(null, '', modifiedNewPageUrl);
                    }

                    if(event.target.className === 'page-link') {
                        if(n !== null) {
                            newPageUrl = this.removeAddParameter(pageUrl, 'page', n);
                            modifiedNewPageUrl = newPageUrl.replace('/results', '');
                            history.pushState(null, '', modifiedNewPageUrl);
                        }
                    }
                }

                fetch(newPageUrl)
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);

                        this.ads_paginator_data = data.ads;
                        this.ads_data = this.ads_paginator_data.data;
                        this.ads_categories = data.categories;
                        this.ads_sexes = data.sexes;
                    })
                    .catch(err => console.log(err));
            },
            removeAddParameter(queryString, key, value) {
                const regex = new RegExp(`([&?])(${key}=)([^\&]+)`);

                let result = queryString.match(regex),
                    newQuery;

                if(result === null) {
                    if(value !== '') {
                        newQuery = queryString + '&' + key + '=' + value;
                    }
                } else {
                    if(result[0].startsWith('?')) {
                        newQuery = queryString.replace(regex, '' + '$2$3');

                        if(value === '') {
                            newQuery = queryString.replace(regex, '?').replace('&', '');
                        }
                    } else {
                        newQuery = queryString.replace(regex, '');
                    }

                    if(value !== '') {
                        newQuery = queryString.replace(regex, '$1$2' + value);
                    }
                }

                return newQuery;
            }
        },
    }
</script>