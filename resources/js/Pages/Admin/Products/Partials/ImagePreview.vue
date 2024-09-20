<script setup>
import {onMounted, ref} from "vue";
import { XMarkIcon, PlusIcon } from '@heroicons/vue/24/solid'
import { v4 as uuidv4 } from 'uuid';

const props = defineProps({
    images:{
        type:[Array, File, String]
    },
    multiple:Boolean,
    name:String,
    btnText:{
        type:String,
        default:'Upload'
    }
})

const emit = defineEmits(['update:modelValue', 'update:deletedImages'])

const files = ref([]);
const imageUrls = ref([]);
const deletedImages = ref([]);

function onFileChange($event){
    if(props.multiple){
        files.value = [...files.value, ...$event.target.files];
        for(let file of $event.target.files){
            file.id = uuidv4();
            readFile(file).then(url=>{
                imageUrls.value.push({
                    url:url,
                    id:file.id
                });
            })
        }
    }else{
        let fileTmp = $event.target.files[0];
        files.value = fileTmp;
        imageUrls.value = [];
        fileTmp.id = uuidv4();
        readFile(fileTmp).then(url=>{
            imageUrls.value.push({
                url:url,
                id:fileTmp.id
            });
        })
    }
    emit('update:modelValue', files.value)
}

function readFile(file){
return new Promise((resolve, reject)=>{
    const fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.onload = () =>{
        resolve(fileReader.result)
    }
    fileReader.onerror = reject;
})
}

onMounted(()=>{
    emit('update:modelValue', [])
    emit('update:deletedImages', deletedImages.value)
    if(props.multiple){
        imageUrls.value = [
            ...imageUrls.value,
            ...props.images.map(im =>({
                ...im,
                isProp:true
            }))
        ]
    }else{
        if(props.images !== ''){
            imageUrls.value.push({
                url:props.images,
                isProp:true
            });
        }
    }
})

function removeImage(image){
    if(image.isProp){
        if(image.deleted){
            deletedImages.value =  deletedImages.value.filter((el)=> el !== image.id)
        }else{
            deletedImages.value.push(image.id)
        }
        image.deleted = !image.deleted;
        emit('update:deletedImages', deletedImages.value)
    }else{
        files.value = files.value.filter(f=>f.id !== image.id);
        emit('update:modelValue', files.value)
        imageUrls.value = imageUrls.value.filter(f=>f.id !== image.id);
    }
}

</script>

<template>
<div class="mb-4 mt-4">
    <div v-if="imageUrls" class="grid grid-cols-2 sm:grid-cols-4 gap-4 col-span-3 mb-4">
        <div v-for="image in imageUrls" class="border-gray-500 relative rounded border border-dashed flex items-center justify-center hover:border-purple-500 overflow-hidden">
            <img :class="{'opacity-25':image.deleted}" class="w-auto" :src="image.url" alt="">
            <span  class="absolute text-center w-full text-white bg-black bottom-0" v-if="image.deleted">To be deleted</span>
            <XMarkIcon v-if="multiple" class="absolute top-1 ring-1 cursor-pointer w-6 right-0" @click="removeImage(image)"></XMarkIcon>
        </div>
    </div>
    <div  class="uploadBtn">
        <span>{{btnText}} <PlusIcon class="w-4 h-4 font-bold"/></span>
        <input :multiple="multiple" @change="onFileChange" :name="name" type="file" class="opacity-0 l-0 t-0 b-0 r-0 absolute">
    </div>
</div>
</template>
