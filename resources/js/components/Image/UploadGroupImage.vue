<template>
    <div class="groupImageBox">
        <div class="goupUpload">
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_1" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_2" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_3" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_4" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_5" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_6" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_7" />
            </div>
            <!-- /.upload -->
            <div class="upload">
                <ImageUploadBox @upload="doUpload" @delete="doDelete" ref="image_8" />
            </div>
            <!-- /.upload -->
        </div>
        <!-- /.goupUpload -->
    </div>
    <!-- /.groupImageBox -->
</template>

<script>
import ImageUploadBox from './LoadItemImage.vue';

export default {
    name: 'UploadGroupImage',
    props:{
        imagesSelf:{
            type:Array,
            default: () => [],
        }
    },
    components:{
        ImageUploadBox,
    },
    data(){
        return {
            images: [],
            imagesSelfItems:[],
        }
    },
    methods:{
        cleanStadeImages(){
            console.log('clean data images')
            this.$refs.image_1.cleanStade();
            this.$refs.image_2.cleanStade();
            this.$refs.image_3.cleanStade();
            this.$refs.image_4.cleanStade();
            this.$refs.image_5.cleanStade();
            this.$refs.image_6.cleanStade();
            this.$refs.image_7.cleanStade();
            this.$refs.image_8.cleanStade();
        },
        getItemFileFromUri(uriFile){
            axios.get('/api/file/uri?uri='+uriFile)
            .then(resp => {this.imagesSelfItems.push(resp.data.data)})
            .catch(e => console.error('Error getting item from uri '+uriFile))
        },
        doUpload(file) {
            this.images.push(file)
            this.$emit('update', this.images);
        },
        doDelete(fileId){
            this.images = this.images.filter(item => {
                if (item.id === fileId) {
                    return false;
                }
                return true;
            });
            this.$emit('update', this.images);
        },
    },
    mounted(){
        if ( this.imagesSelf.length > 0) {
            this.imagesSelf.forEach(i => {
                if (typeof i === 'string'){
                    this.getItemFileFromUri(i);
                }
            });
        }
    }
}
</script>

<style scoped lang="scss">
    $size-screen: 670px;
    $fr-size: 8.1em;
    $p: .7em;
    .groupImageBox{
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: $p;
        padding-bottom: $p;
    }

    .goupUpload{
        margin: .7em;
        display: grid;
        grid-template-columns: repeat(4, $fr-size);
        grid-template-rows: repeat(2, $fr-size);
        column-gap: .7rem;
        row-gap: .7rem;
        @media (max-width: $size-screen){
            grid-template-columns: repeat(2, $fr-size);
            grid-template-rows: repeat(4, $fr-size);
        }
        .upload:nth-child(1){
            grid-column: 1/2;
            grid-row: 1/2;
        }
        .upload:nth-child(2){
            grid-column: 2/3;
            grid-row: 1/2;
        }
        .upload:nth-child(3){
            grid-column: 3/4;
            grid-row: 1/2;
            @media (max-width: $size-screen){
                grid-column: 1/2;
                grid-row: 2/3;
            }
        }
        .upload:nth-child(4){
            grid-column: 4/5;
            grid-row: 1/2;
            @media (max-width: $size-screen){
                grid-column: 2/3;
                grid-row: 2/3;
            }
        }
        .upload:nth-child(5){
            grid-column: 1/2;
            grid-row: 2/3;
            @media (max-width: $size-screen){
                grid-column: 1/2;
                grid-row: 3/4;
            }
        }
        .upload:nth-child(6){
            grid-column: 2/3;
            grid-row: 2/3;
            @media (max-width: $size-screen){
                grid-column: 2/3;
                grid-row: 3/4;
            }
        }
        .upload:nth-child(7){
            grid-column: 3/4;
            grid-row: 2/3;
            @media (max-width: $size-screen){
                grid-column: 1/2;
                grid-row: 4/5;
            }
        }
        .upload:nth-child(8){
            grid-column: 4/5;
            grid-row: 2/3;
            @media (max-width: $size-screen){
                grid-column: 2/3;
                grid-row: 4/5;
            }
        }
    }
</style>