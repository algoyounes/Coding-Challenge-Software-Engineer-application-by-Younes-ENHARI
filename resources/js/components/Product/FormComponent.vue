<template>
    <b-container>
        <b-button class="my-5" variant="primary" @click="$router.go(-1)"><b-icon icon="arrow-left" aria-hidden="true"></b-icon> </b-button>

        <b-alert variant="success" :show="alert.status">{{ alert.message }}</b-alert>

        <b-form @submit.prevent="submitNewProduct" @reset="onReset">
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
                    placeholder="Enter product name"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Product description:" label-for="textarea">
                <b-form-textarea
                    id="textarea"
                    name="description"
                    v-model="form.description"
                    placeholder="Enter description..."
                    rows="3"
                    max-rows="6"
                    required
                ></b-form-textarea>
            </b-form-group>

            <b-form-group id="input-group-3" label="Product price:" label-for="price">
                <b-form-input
                    id="price"
                    type="number"
                    name="price"
                    v-model="form.price"
                    required
                    step="0.10"
                    min="0"
                    placeholder="Enter product price"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-4" label="Product category:" label-for="image">
                <b-form-select
                    v-model="form.category_id"
                    :options="categories"
                    value-field="id"
                    text-field="name"
                    disabled-field="notEnabled"
                    multiple
                    required
                >
                </b-form-select>
            </b-form-group>

            <b-form-group id="input-group-4" label="Product image:" label-for="image">
                <input type="file" class="form-control"
                    @change="onLoadFileChange"
                />
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
                imageRules: [
                    value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
                ],
                form: {
                    name: '',
                    description: '',
                    image : null,
                    file: null,
                    category_id: []
                },
                alert: {
                    message: '',
                    status: false
                }
            }
        },
        methods: {

            onLoadFileChange(e){
                console.log(e.target.files[0]);
                this.form.image = e.target.files[0];
                // let fileReader = new FileReader();
                // fileReader.readAsDataURL(e.target.files[0]);
                // fileReader.onload = (e) => {
                //     this.form.image = e.target.result
                // }
            },
            init() {
                axios.get(`/api/categories`)
                        .then(res => {
                            console.log(res.data);
                            this.categories = res.data;
                        })
                        .catch(err => {});

                if (this.id != null){
                    axios.get(`/api/products/${this.id}`)
                            .then(res => {
                                let category_ids = []
                                this.form = res.data
                                res.data.categories.forEach(
                                    category => category_ids.push(category.id)
                                );
                                this.form.category_id = category_ids
                            })
                            .catch(err => {});
                }
            },
            submitNewProduct() {
                let formData = new FormData();

                formData.append("name", this.form.name);
                formData.append("description", this.form.description);
                formData.append("price", this.form.price);
                formData.append("category_id", this.form.category_id);
                formData.append("image", this.form.image);

                console.log("data : ",this.form);

                if (this.id == null){
                    this.addNewProduct(formData)
                }else{
                    formData.append("_method", "put");
                    this.updateProduct(formData)
                }
            },
            onReset() {
                this.form = {
                    name: '',
                    description: '',
                    price: '',
                    image: '',
                    category_id: []
                }
            },
            addNewProduct(formData) {
                axios.post(`/api/products`, formData)
                        .then(res => {
                            if(res.status == 201){
                                this.alert.status = true
                                this.alert.message = "Product added with success"
                                this.onReset()
                            }
                        })
                        .catch(err => {
                            console.log('error', err)
                        });
            },
            updateProduct(formData) {
                axios.post(`/api/products/${this.id}`, formData)
                    .then(res => {
                        if(res.status == 200){
                            this.alert.status = true
                            this.alert.message = "Product updated with success"
                        }else{
                            this.alert.status = false
                            this.alert.message = "Somethings are not fielded correctly"
                        }
                    })
                    .catch(err => {
                        console.log('error', err)
                    });
            },
        }
    }
</script>
