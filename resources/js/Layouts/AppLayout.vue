<template>
    <div class="min-h-screen flex flex-col font-sans text-slate-700 bg-gray-50">
      <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center h-20">
            <div class="flex items-center gap-2">
              <div class="w-8 h-8 rounded-full border-2 border-teal-500 flex items-center justify-center text-teal-600 font-bold">C</div>
              <span class="text-xl font-bold text-slate-800 tracking-tight">CMU <span class="text-teal-500">Coop</span></span>
            </div>
  
            <nav class="hidden md:flex gap-8 items-center text-sm font-medium">
              <a href="#" class="text-teal-600">Home</a>
              <a href="#" class="text-slate-500 hover:text-teal-600 transition">About Us</a>
              <a href="#" class="text-slate-500 hover:text-teal-600 transition">Resources</a>
              <a href="#" class="text-slate-500 hover:text-teal-600 transition">Contact</a>
              <button class="text-slate-400 hover:text-teal-600">
                <SearchIcon class="w-5 h-5" />
              </button>
            </nav>
  
            <button class="md:hidden text-slate-500">
              <MenuIcon class="w-6 h-6" />
            </button>
          </div>
        </div>
      </header>
  
      <main class="flex-grow">
        <slot />
      </main>
  
      <footer class="bg-white border-t border-gray-100 pt-12 pb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
              <h3 class="font-bold text-lg mb-4 text-slate-800">CMU Coop</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Creating value for our members since 2022.
              </p>
            </div>
            <div class="md:col-span-2 flex flex-col md:items-end justify-center text-sm text-slate-500 space-y-2">
               <div class="flex items-center gap-2">
                  <PhoneIcon class="w-4 h-4" /> +66-53-943-030
               </div>
               <div class="flex items-center gap-2">
                  <MailIcon class="w-4 h-4" /> info@cmucoop.com
               </div>
            </div>
          </div>
          <div class="text-center text-xs text-slate-400 mt-8 border-t border-gray-50 pt-4">
            Copyright © 2025. All rights reserved.
          </div>
        </div>
      </footer>
    </div>
  </template>
  
  <script setup>
  import { SearchIcon, MenuIcon, PhoneIcon, MailIcon } from 'lucide-vue-next';
  </script>