<template>
    <b-container>
        <b-button class="my-5" variant="primary" @click="$router.go(-1)"><b-icon icon="arrow-left" aria-hidden="true"></b-icon> </b-button>

        <b-alert variant="success" :show="alert.status">{{ alert.message }}</b-alert>

        <b-form @submit.prevent="submitNewCategory" @reset="onReset">
            <b-form-group
                id="input-group-1"
                label="Name:"
                label-for="name"
            >
                <b-form-input
                    id="name"
                    type="text"
                    name="name"
                    v-model="form.name"
                    required
                    placeholder="Enter category name"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-4" label="Parent category:">
                <b-form-select
                    v-model="form.parent_id"
                    :options="categories"
                    value-field="id"
                    text-field="name"
                    disabled-field="notEnabled"
                >
                    <b-form-select-option :value="null">Select parent category</b-form-select-option>
                </b-form-select>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
    </b-container>
</template>

<script>
    export default {
        props: ['id'],
        created() {
            this.init()
        },
        data() {
            return {
                categories: [],
                form: {
                    name: '',
                    parent_id: null
                },
                alert: {
                    message: '',
                    status: false
                }
            }
        },
        methods: {
            init() {
                axios.get(`/api/categories`)
                        .then(res => {
                            this.categories = res.data
                        })
                        .catch(err => {});

                if (this.id != null){
                    axios.get(`/api/categories/${this.id}`)
                            .then(res => {
                                this.form = res.data
                            })
                            .catch(err => {});
                }
            },
            submitNewCategory() {
                let formData = new FormData();

                formData.append("name", this.form.name);
                formData.append("parent_id", this.form.parent_id);

                if (this.id == null){
                    this.addNewCategory(formData)
                }else{
                    this.updateCategory(formData)
                }
            },
            onReset() {
                this.form = {
                    name: '',
                    parent_id: null
                }
            },
            addNewCategory(formData) {
                axios.post(`/api/categories`, formData)
                        .then(res => {
                            if(res.status == 201){
                                this.alert.status = true
                                this.alert.message = "Category was added with success"
                                this.onReset()
                                this.init()
                            }
                        })
                        .catch(err => {
                            console.log('error', err)
                        });
            },
            updateCategory() {
                axios.put(`/api/categories/${this.id}`, this.form)
                        .then(res => {
                            if(res.status == 200){
                                this.alert.status = true
                                this.alert.message = "Category was updated with success"
                            }
                        })
                        .catch(err => {
                            console.log('error', err)
                        });
            }
        }
    }
</script>
