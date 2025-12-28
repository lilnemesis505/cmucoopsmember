<template>
    <AppLayout>
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <section class="relative mb-20">
          <div class="absolute top-0 left-0 w-32 h-32 border-t-8 border-l-8 border-blue-600/90 -translate-x-4 -translate-y-4 z-0 hidden md:block"></div>
          <div class="absolute bottom-0 right-0 w-32 h-32 border-b-8 border-r-8 border-teal-500/90 translate-x-4 translate-y-4 z-0 hidden md:block"></div>
  
          <div class="relative z-10 bg-white shadow-xl overflow-hidden rounded-lg">
            <div class="w-full h-64 md:h-96 relative">
              <img 
                src="https://ik.imagekit.io/cmucoopsmember/member.jpg?updatedAt=1766539668593" 
                alt="Campus Life" 
                class="w-full h-full object-cover"
              />
            </div>
          </div>
        </section>
  
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 max-w-5xl mx-auto">
          <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 text-center group cursor-pointer">
            <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition overflow-hidden">
              <img 
                src="https://ik.imagekit.io/cmucoopsmember/logo/member3.png?updatedAt=1766716604659" 
                alt="Member Connect" 
                class="w-full h-full object-contain"
              />
            </div>
            <h3 class="font-bold text-lg text-slate-800 mb-2">Member Connect</h3>
            <p class="text-sm text-slate-500">Member services, packages and member contracts.</p>
          </div>
  
          <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 text-center group cursor-pointer">
            <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
              <ShoppingCartIcon class="w-7 h-7" />
            </div>
            <h3 class="font-bold text-lg text-slate-800 mb-2">Store Online</h3>
            <p class="text-sm text-slate-500">Shopper operation and available for list services.</p>
          </div>
  
          <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 text-center group cursor-pointer">
            <div class="w-14 h-14 bg-indigo-50 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition overflow-hidden">
              <img 
                src="https://ik.imagekit.io/cmucoopsmember/logo/xcademy.png?updatedAt=1766551989903" 
                alt="X-Academy" 
                class="w-full h-full object-contain"
              />
            </div>
            <h3 class="font-bold text-lg text-slate-800 mb-2">X-Academy</h3>
            <p class="text-sm text-slate-500">School services online, academic destination.</p>
          </div>
        </section>
  
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
          <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border-l-4 border-blue-500 flex items-center gap-4 cursor-pointer">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
              <FileTextIcon class="w-6 h-6" />
            </div>
            <div class="text-left">
              <h3 class="font-bold text-lg text-slate-800">ตรวจสอบข้อมูล</h3>
              <p class="text-xs text-slate-500">Discover extensive messages regarding and Easy Point.</p>
            </div>
          </div>
  
          <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border-l-4 border-teal-500 flex items-center gap-4 cursor-pointer">
            <div class="w-17 h-17 flex items-center justify-center flex-shrink-0">
              <img 
                src="https://ik.imagekit.io/cmucoopsmember/logo/easy1.png?updatedAt=1766638379250" 
                alt="Easy Point" 
                class="w-full h-full object-contain"
              />
            </div>
            <div class="text-left">
              <h3 class="font-bold text-lg text-slate-800">Easy Point</h3>
              <p class="text-xs text-slate-500">Want convenience in provider entertaiment.</p>
            </div>
          </div>
        </section>
  
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { 
    ShoppingCartIcon, 
    FileTextIcon 
  } from 'lucide-vue-next';
  </script>