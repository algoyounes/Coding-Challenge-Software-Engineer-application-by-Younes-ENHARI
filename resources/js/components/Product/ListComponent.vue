<template>
    <b-container>
            <b-button class="my-5" variant="primary" to="/product/add">Add new product</b-button>

            <b-alert variant="danger" dismissible :show="alert.status">
                {{ alert.message }}
            </b-alert>

            <b-row  v-if="init_products.length > 0">
                <b-form-group class="col-4" label="Min price:" label-for="min_price">
                    <b-form-input
                        id="min_price"
                        type="number"
                        v-model="filter.minPrice"
                        step="0.10"
                        min="0"
                        placeholder="Min price"
                        @input="filterProductByMinPrice"
                    ></b-form-input>
                </b-form-group>

                <b-form-group class="col-4" label="Max price:" label-for="max_price">
                    <b-form-input
                        id="max_price"
                        type="number"
                        v-model="filter.maxPrice"
                        step="0.10"
                        min="0"
                        placeholder="Max price"
                        @input="filterProductByMaxPrice"
                    ></b-form-input>
                </b-form-group>

                <b-form-group class="col-4" id="input-group-4" label="Filter by category:">
                    <b-form-select
                        v-model="filter.category_id"
                        :options="categories"
                        value-field="id"
                        text-field="name"
                        disabled-field="notEnabled"
                        @input="filterProductByCategory"
                    >
                        <b-form-select-option :value="null">Select a category</b-form-select-option>
                    </b-form-select>
                </b-form-group>
            </b-row>

            <b-table striped hover :items="products" :fields="fields" v-if="products.length > 0">

                <template v-slot:cell(category)="row" >
                    <span v-for="(category,index) in row.item.categories" :key="index"> {{ category.name }} <br></span>
                </template>

                <template v-slot:cell(image)="row" >
                    <b-img thumbnail fluid height="60" width="60" :src="`${row.item.image}`" alt="Not rounded image"></b-img>
                </template>

                <template v-slot:cell(options)="row" >
                    <b-button size="sm" variant="primary" class="mr-2" @click="$router.push(`product/edit/${row.item.id}`)">
                        <b-icon icon="pencil" aria-hidden="true"></b-icon>
                    </b-button>

                    <b-button size="sm" class="mr-2" variant="danger" v-b-modal="`showModal_${row.item.id}`"><b-icon icon="trash" aria-hidden="true"></b-icon></b-button>

                    <b-modal :ref="`showModal_${row.item.id}`" :id="`showModal_${row.item.id}`" title="Are you sure you want to delete this product?" hide-footer>
                        <b-button variant="danger" class="col-12 mb-2" @click="deleteProduct(row.item.id, row.index )">Delete</b-button>
                        <b-button class="col-12" @click="$bvModal.hide(`showModal_${row.item.id}`)">Cancel</b-button>
                    </b-modal>
                </template>

            </b-table>

            <b-alert show variant="danger" class="col-sm-12 text-center" v-else>There's no product for now!</b-alert>

    </b-container>
</template>

<script>
    export default {
        created() {
            this.init()
        },
        data() {
            return {
                init_products: [],
                categories: [],
                fields: ['name',
                        'description',
                        'price',
                        'category',
                        'image',
                        'options'
                    ],
                products: [],
                alert: {
                    message: '',
                    status: false
                },
                filter: {
                    minPrice: 0,
                    maxPrice: 0,
                    category_id: null
                }
            }
        },
        methods: {
            init() {
                axios.get(`/api/products`)
                        .then(res => {
                            this.products = res.data
                            this.init_products = res.data
                        })
                        .catch(err => {});

                axios.get(`/api/products/create`)
                        .then(res => {
                            this.categories = res.data
                        })
                        .catch(err => {});
            },
            deleteProduct(product_id, index) {
                axios.delete(`/api/products/${product_id}`)
                    .then(res => {
                        if(res.status == 200){
                            this.products.splice(index, 1)
                            this.init_products.splice(index, 1)
                            this.$refs[`showModal_${product_id}`].hide()
                            this.alert.status = true
                            this.alert.message = "Product was delete seccessufly"
                        }
                    })
                    .catch(err => {});
            },
            filterProductByMinPrice() {
                let min_price = this.filter.minPrice
                if(this.filter.maxPrice || this.filter.category_id){
                    this.products = this.products.filter(function (el) {
                        return el.price >= min_price
                    })
                }else if(this.filter.minPrice){
                    this.products = this.init_products.filter(function (el) {
                        return el.price >= min_price
                    })
                }else{
                    this.products = this.init_products
                }
            },
            filterProductByMaxPrice() {
                let max_price = this.filter.maxPrice
                if(this.filter.minPrice || this.filter.category_id){
                    this.products = this.products.filter(function (el) {
                        return el.price <= max_price
                    })
                }else if(this.filter.maxPrice){
                    this.products = this.init_products.filter(function (el) {
                        return el.price <= max_price
                    })
                }else{
                    this.products = this.init_products
                }
            },
            filterProductByCategory() {
                let category_id = this.filter.category_id
                if(this.filter.minPrice || this.filter.maxPrice){
                    this.products = this.products.filter(function (el) {
                        let stat = false
                        el.categories.forEach(
                            category => category.id == category_id ? stat = true : stat = false
                        )
                        return stat
                    })
                }else if(this.filter.category_id){
                    this.products = this.init_products.filter(function (el) {
                        let stat = false
                        el.categories.forEach(
                            category => category.id == category_id ? stat = true : stat = false
                        )
                        return stat
                    })
                }else{
                    this.products = this.init_products
                }
            }
        }
    }
</script>
