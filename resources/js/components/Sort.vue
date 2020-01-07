<template>
    <div class="content-holder">
        <div class="card mb-2">
            <div class="card-header">Sortiranje</div>

            <div class="card-body">
                <form action="javascript:void(0)">
                    <div class="form-group">
                        <select id="date"
                                class="form-control"
                                name="date" autocomplete="category" autofocus @change="handleSorting($event)">
                            <option value="">Sortiraj po datumu</option>
                            <option value="asc">ASC</option>
                            <option value="desc">DESC</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="list-holder">
            <div class="card mb-2" v-for="ad_data in ads_data" v-bind:key="ad_data.id">
                <div class="card-header"><a :href="'ads/' + ad_data.id">{{ ad_data.title }}</a></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img :src="ad_data.images[0].image_path" alt="ad-image" style="height: 100px;" />
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
    </div>
</template>

<script>
    export default {
        props: ['ads'],
        mounted() {
            console.log('Component mounted.');
            // console.log(JSON.parse(this.ads));
        },
        data() {
            return {
                ads_data: []
            }
        },
        created() {
            this.ads_data = this.ads;
            console.log(this.ads_data);
        },
        methods: {
            handleSorting(event){
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
            }
        }
    }
</script>