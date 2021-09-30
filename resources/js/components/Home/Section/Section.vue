<template>
    <div class="sectionItem">
        <div class="sectionContent">
            <h3 class="title">
                {{title | short}}
            </h3>
            <!-- /.title -->
            <div class="descripption">
                {{description | short}}
            </div>
            <!-- /.descripption -->
        </div>
        <!-- /.sectionContent -->
        
        <div class="buttonBox">
            <!-- Edit Icon -->
            <svg 
                @click="editMode"
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Рндагувати секцію" 
                xmlns="http://www.w3.org/2000/svg"
                 width="24" 
                 height="24" 
                 fill="currentColor" 
                 class="bi bi-pencil-square" 
                 viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>

            <!-- Delete Icon -->
            <svg 
            @click="destroySubmit"
            data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="Видалити секцію" 
            xmlns="http://www.w3.org/2000/svg" 
            width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
            </svg>
        </div>
        <!-- /.buttonBox -->

        <div  v-if="edit" :class="{'addActive': editAnim}" class="editBox mt-2">
            <input 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Ім'я секції"
                v-model="title"
                placeholder="Уведіть нове ім'я секції"
                type="text" 
                class="form-control"
            >

            <textarea
                cols="30" 
                rows="5"
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Опис секції"
                v-model="description"
                class="form-control"
                placeholder="Опишіть секцію"
            ></textarea>

             <div class="form-group mt-2 c-box" @click="show = !show">
                    <!-- Enable icon -->
                    <svg v-if="show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                        <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                    </svg>

                    <!-- Disable icon -->
                    <svg v-if="!show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                        <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                    </svg>

                    <span class="showToggleText">
                        {{showToggleText}}
                    </span>
                    <!-- /.showToggleText -->
                    
                </div>
                <!-- /.form-group -->

            <div class="form-group ml-4 mt-3">
                <button 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="Зберегти нові дані секції"
                    @click="editSubmit" 
                    type="button" 
                    class="btn btn-dark btn-lg"
                >
                    Зберегти секцію
                </button>
                <!-- /.btn btn-dark btn-lg -->
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.editBox -->
    </div>
    <!-- /.sectionItem -->
</template>

<script>
import Swal from 'sweetalert2';

export default {
    name: 'SectionItem',
    props:{
        section:{
            type: Object,
        },
    },
    data() {
        return {
            title: this.section.title,
            description: this.section.description,
            edit: false,
            editAnim: false,
            show: this.section.show,
        }
    },
    computed:{
        showToggleText(){
            if (this.show) {
                return 'Показувати на сторінці';
            }
            return 'Не показувати';
        },
        dataFromEdit(){
            return {
                title: this.title,
                description: this.description,
                show: this.show,
            }
        },
    },
    filters:{
        short( str) {
            if (str.length > 85) {
                return str.substring(0, 85) + '...';
            } else {
                return str;
            }
        },
    },
    methods:{
        load(load){
            this.$emit('load', load);
        },
        editMode(){
            this.edit = true;
            setTimeout(() => {
                this.editAnim = !this.editAnim;
                if (!this.editAnim) {
                    setTimeout(() => this.edit = false, 200);
                }
                }, 200);
        },
        editSubmit(){
            this.load(true);
            route('sections.update', {section: this.section.id})
            .then(uri => {
                axios.put(uri.data,this.dataFromEdit )
                .then(response => {
                        this.load(false);
                        this.$emit('update', true);
                        this.edit = false;
                        this.editAnim = false;
                        Swal.fire({
                            title: 'Відредаговано',
                            icon: 'success',
                            timer: 850,
                        });
                }).catch(err => Swal.fire('Error edit', '', 'error'))
            }).catch(err => Swal.fire('Error grtting route', '', 'error'))
        },
        destroySubmit(){
            this.load(true);
            route('sections.destroy', {section: this.section.id})
            .then(uri => {
                axios.delete(uri.data)
                .then(response => {
                        this.load(false);
                        this.$emit('update', true);
                        this.edit = false;
                        this.editAnim = false;
                        Swal.fire({
                            title: 'Видалено',
                            icon: 'success',
                        });
                }).catch(err => Swal.fire('Error edit', '', 'error'))
            }).catch(err => Swal.fire('Error grtting route', '', 'error'))
        },
    },
    updated(){
        setTooltip();
    }
}
</script>

<style scoped lang="scss">

.c-box{
    display: flex;
    padding: .7rem;
    border: 1px solid #383838;
    cursor: pointer;
    border-radius: 9px;
    align-items: center;
    column-gap: .7rem;
    span{
        font-weight: bold;
        text-transform: uppercase;
        font-size: 20px;

    }
}

.title{
    padding: 0;
    margin: .9rem .1rem;
    line-height: 9px;
}

.descripption{
    font-size: 12px;
    color: #666;
    padding-top: .2rem;
    border-top: 1px solid #383838;
}

.sectionItem{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: .3rem;
    border: 1px solid #383838;
    border-radius: 10px;
    margin: .3rem;
}

.buttonBox{
    display: flex;
    align-items: center;
    column-gap: .7rem;
    
}

.editBox{
    width: 100%;
    transform: scale(0, 0);
    textarea{
        margin-top: .3rem;
    }
    transition: all .3s;
}

.addActive{
    transform: scale(1, 1);
    transition: all .3s;
}
</style>
