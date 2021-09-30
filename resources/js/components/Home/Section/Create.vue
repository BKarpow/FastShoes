<template>
    <div id="createSection">
        <div class="btn-group my-2 d-block">
            <button 
                
                title="Показати форму створення нової секції"
                v-if="!showForm"
                @click="showForm = !showForm"
                class="btn btn-info btn-lg"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                </svg> Створити секцію
            </button>
            <!-- /.btn btn-info btn-lg -->

            <button 
                
                title="Сховати форму створення нової секції"
                v-if="showForm"
                @click="showForm = !showForm"
                class="btn btn-primary"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                </svg> Відміна
            </button>
            <!-- /.btn btn-info btn-lg -->
        </div>
        <!-- /.btn-group d-block -->
        <div id="createForm" v-if="showForm">
            <h5>Створити нову секцію</h5>
            <div class="form-group">
                <input 
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="Назва секціїї"
                    placeholder="Як назвем?"
                    type="text" 
                    v-model="title"
                    class="form-control col-md-4"
                    >
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <textarea 
                    cols="3" 
                    rows="3"
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Опис секції"
                    v-model="description"
                    class="form-group col-md-4"
                ></textarea>
                <!-- /#.form-group -->
                <div class="form-group">
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input v-model="show" type="checkbox" checked class="btn-check" id="btncheck1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck1">Публічно</label>
                    </div>
                    
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <button 
                        
                        title="Створити секцію"
                        @click="onSubmit"
                    class="btn btn-success"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg> Створити
                    </button>
                    <!-- /.btn btn-success -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /#createForm -->
        
    </div>
    <!-- /#createSection -->
</template>

<script>
import Swal from 'sweetalert2';
export default {
    name: 'SectionCreate',
    data(){
        return {
            showForm: false,
            title: '',
            description: '',
            show: true,
        }
    },
    methods:{
        load(s){
            this.$emit('load', s);
        },
        onSubmit(){
            this.load(false);
            route('sections.store')
            .then(uri => {
                axios.post(uri.data, this.dataForm)
                .then(resp => {
                    this.load(true);
                    this.$emit('update', true);
                    this.title = '';
                    this.description = '';
                    this.showForm = false;
                }).catch(err => {
                    Swal.fire('Error create', '', 'error');
                })
            }).catch(err => {console.error('Error getting name')})
        }
    },
    computed:{
        dataForm(){
            return {
                title: this.title,
                description: this.description,
                show: this.show,
            }
        }
    },
    updated(){
        setTooltip();
    }
}
</script>