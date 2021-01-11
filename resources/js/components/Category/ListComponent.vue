<template>
    <b-container>

        <b-button class="my-5" variant="primary" to="/category/add">Add new Category</b-button>

        <b-alert variant="danger" dismissible :show="alert.status">
                {{ alert.message }}
        </b-alert>

        <b-table striped hover :items="categories" :fields="fields" v-if="categories.length > 0">
            <template v-slot:cell(options)="row" >

                <b-button size="sm" variant="primary" class="mr-2" @click="$router.push(`category/edit/${row.item.id}`)">
                    Update
                </b-button>

                <b-button size="sm" class="mr-2" variant="danger" v-b-modal="`showModal_${row.item.id}`">Delete</b-button>

                <b-modal :ref="`showModal_${row.item.id}`" :id="`showModal_${row.item.id}`" title="Are you sure you want to delete this category?" hide-footer>
                    <b-button variant="danger" class="col-12 mb-2" @click="deleteCategory(row.item.id, row.index)">Delete</b-button>
                    <b-button class="col-12" @click="$bvModal.hide(`showModal_${row.item.id}`)">Cancel</b-button>
                </b-modal>

            </template>
        </b-table>

        <b-alert show variant="danger" class="col-sm-12 text-center" v-else>There's no categories for now!</b-alert>

    </b-container>
</template>

<script>
    export default {
        created() {
            this.init()
        },
        data() {
            return {
                categories: [],
                fields: ['name',
                        { key: 'parent.name', label: 'Parent Category' },
                        'options'
                    ],
                alert: {
                    message: '',
                    status: false
                },
            }
        },
        methods: {
            init() {
                axios.get(`/api/categories`)
                        .then(res => {
                            this.categories = res.data
                        })
                        .catch(err => {});
            },
        }
    }
</script>
