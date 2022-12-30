<template>
    <div class="d-sm-inline-flex w-100">
        <div>
            <img :src="image" />
        </div>
        <div class="align-self-center ml-sm-3 mt-3 mt-sm-0">
            <input type="file" @change="onImageChange($event)">
        </div>

    </div>
</template>

<script>
import { abstractField } from 'vue-form-generator';
export default {
    name: 'FieldResumeImage',

    mixins: [abstractField],

    data() {
        return {
            reader: new FileReader(),
            image: this.model[this.schema.model],
        }
    },

    created() {
        this.reader.onload = (e) => {
            const blob = e.target.result;
            this.image = blob;
            this.model[this.schema.model] = blob;
        }
    },
    methods: {
        onImageChange(e) {
            this.reader.readAsDataURL(e.target.files[0]);

        }
    },
}

</script>
<style scoped>
img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
}
</style>