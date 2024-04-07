<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { onMounted } from 'vue';

    onMounted(() => {
        activeMenu('inicio')
    })

    const activeMenu = (menu) => {
        $( ".menu_"+ menu).addClass( 'active')
    }

</script>

<template>
    
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        
        <template #header>
            <div class="row mb-2">
            
                <div class="col-sm-6">
                    <h1 class="m-0">Starter Page</h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div>
                
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>

                    <i class="fab fa-wpforms"></i>
                    
                </div>
            </div>
        </div>

    </AuthenticatedLayout>

    

</template>
