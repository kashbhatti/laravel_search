<template>
    <div
        class="search__container"
        v-click-outside="hide"
    >
        <form class="form__container form minisearch">
            <input
                type="text"
                placeholder="Search"
                id="query"
                name="query"
                v-on:input="debounceInput"
                v-on:click="show"
                v-on:keydown.esc="hide"
                v-model="query"
                class="search__input"
            />
            <div class="actions">
                <button
                    type="button"
                    v-if="query !== ''"
                    v-on:click="clear"
                    title="Clear"
                    class="action__button action__button_type_clear"
                >
                    <i class="fas fa-times"></i>
                </button>
                <button
                    title="Search"
                    v-on:click="search"
                    class="action__button action__button_type_search"
                >
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <div
            class="loading"
            v-if="loading"
            ><img
                src="/image/loading.gif"
                alt="loading"
                title="loading"
        /></div>
        <div
            v-if="!nodata"
            class="search__results"
            v-bind:class="{active: isActive}"
            tabindex="-1"
            v-on:keydown.esc="hide"
        >
            <div class="search__legend">
                <div class="search__display-mode">
                    <a
                        href="#"
                        class="search__toggle-link link_mode_grid active"
                        v-on:click="toggleDataMode('grid')"
                        title="Grid View"
                        ><i class="fas fa-th"></i
                    ></a>
                    <a
                        href="#"
                        class="search__toggle-link link_mode_list"
                        v-on:click="toggleDataMode('list')"
                        title="List View"
                        ><i class="fas fa-list"></i
                    ></a>
                </div>
                <div class="search__display-sort">
                    <a
                        href="#"
                        class="search__toggle-link link_sort_relevance active"
                        v-on:click="toggleDataSort('relevance')"
                        title="Relevance"
                        ><i class="fas fa-redo"></i
                    ></a>
                    <a
                        href="#"
                        class="search__toggle-link link_sort_asc"
                        v-on:click="toggleDataSort('asc')"
                        title="Price Asc"
                        ><i class="fas fa-chevron-up"></i
                    ></a>
                    <a
                        href="#"
                        class="search__toggle-link link_sort_desc"
                        v-on:click="toggleDataSort('desc')"
                        title="Price Desc"
                        ><i class="fas fa-chevron-down"></i
                    ></a>
                </div>
            </div>
            <div
                class="search__wrapper"
                v-on:scroll="scroll"
                data-mode="grid"
            >
                <div
                    v-for="row in allData"
                    class="search__results-item"
                >
                    <search-image
                        v-bind:item_name="row.name"
                        v-bind:item_desc="row.description"
                        v-bind:item_image="row.image"
                        v-bind:item_price="row.price"
                    ></search-image>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import SearchImage from './SearchImage.vue';
import vClickOutside from 'click-outside-vue3'

export default {
    components: {
        'search-image': SearchImage
    },
    directives: {
      clickOutside: vClickOutside.directive
    },
    data: () => ({
        allData: [],
        query: '',
        nodata: true,
        loading: false,
        offSet: 0,
        lastScrollUpdate: 0,
        isActive: false,
        dataMode: 'grid',
        dataSort: 'relevance',
    }),
    methods: {
        search(params = {}) {
            this.allData = [];
            this.loading = true;
            this.offSet = 0;
            const formData = new FormData();
            formData.append('query', this.query);
            formData.append('offSet', this.offSet);
            if (typeof params !== undefined && Object.keys(params).length > 0) {
                formData.append('sort', params["sort"]);
            }
            axios.post('/search', formData, {}).then((response) => {
                if (response.data['data'].length > 0) {
                  let thisLength = response.data['data'].length;
                    for (let i = 0; i < thisLength; i++) {
                        this.allData.push(response.data['data'][i]);
                    }
                    this.isActive = true;
                    this.nodata = false;
                    this.loading = false;
                } else {
                    this.loading = false;
                    this.allData = [];
                    this.nodata = true;
                    this.offset = 0;
                }
            });
        },
        clear() {
          this.isActive =false;
          this.query = '';
          this.nodata = true;
          this.loading = false;
          this.allData = [];
          this.offset = 0;
        },
        loadMore() {
            this.loading = true;
            this.offSet += 12;
            const formData = new FormData();
            formData.append('query', this.query);
            formData.append('offSet', this.offSet);
            formData.append('sort', this.dataSort);
            axios.post('/search', formData, {}).then((response) => {
                if (response.data['data'].length > 0) {
                    let thisLength = response.data['data'].length;
                    for (let i = 0; i < thisLength; i++) {
                        this.allData.push(response.data['data'][i]);
                    }
                    this.nodata = false;
                    this.loading = false;
                }
            });
        },
        debounceInput: _.debounce(function (e) {
          this.query = e.target.value;
          if (this.query.length <= 2) {
            this.nodata = true;
            this.loading = false;
            this.allData = [];
            this.offset = 0;
          } else {
            this.search();
          }
        }, 1500),
        scroll: function (e) {
            var scrollBar = e.target;
            if ((scrollBar.scrollTop + scrollBar.clientHeight >= scrollBar.scrollHeight - 20)) {
                var t = new Date().getTime();
                if ((t - this.lastScrollUpdate) > 1000) {
                    this.lastScrollUpdate = t;
                    this.loadMore();
                }
            }
        },
        show: function () {
            this.isActive = true;
        },
        hide: function () {
            this.isActive = false;
        },
        toggleDataMode: function (mode) {
            $('.search__wrapper').attr('data-mode', mode);
            if (mode === 'grid') {
                $('.link_mode_list').removeClass('active');
                $('.link_mode_grid').addClass('active');
            } else {
                $('.link_mode_list').addClass('active');
                $('.link_mode_grid').removeClass('active');
            }
            this.dataMode = mode;
        },
        toggleDataSort: function (sort) {
            this.dataSort = sort;
            var params = {};
            params["sort"] = sort;
            this.search(params);
            this.offSet = 0;
            $('.link_sort_relevance').removeClass('active');
            $('.link_sort_asc').removeClass('active');
            $('.link_sort_desc').removeClass('active');
            if (sort === 'relevance') {
                $('.link_sort_relevance').addClass('active');
            }
            if (sort === 'asc') {
                $('.link_sort_asc').addClass('active');
            }
            if (sort === 'desc') {
                $('.link_sort_desc').addClass('active');
            }
        },
    }
}
</script>
