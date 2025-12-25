<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler
} from 'chart.js';
import { Line } from 'vue-chartjs';

// --- 1. ลงทะเบียน Chart.js ---
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Filler
);

// --- 2. Greeting Logic ---
const getGreeting = () => {
    const hour = new Date().getHours();
    if (hour < 12) return 'สวัสดีตอนเช้า';
    if (hour < 18) return 'สวัสดีตอนบ่าย';
    return 'สวัสดีตอนเย็น';
};

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top',
      align: 'end',
      labels: { usePointStyle: true, boxWidth: 8 }
    }
  },
  scales: {
    y: {
      grid: { borderDash: [4, 4], drawBorder: false },
      ticks: { display: true }
    },
    x: {
      grid: { display: false, drawBorder: false }
    }
  }
};
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard Overview" />

        <div class="space-y-6">
            
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ getGreeting() }} คุณ Admin 👋</h2>
                </div>
                <div class="hidden md:flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-600">System Online</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white rounded-sm border border-slate-200 shadow-sm p-6 flex flex-col justify-between h-40">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 mb-4">
                        <i class="bi bi-eye text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">3.456K</h4>
                        <div class="flex justify-between items-end">
                            <span class="text-sm text-slate-500">ยอดเข้าชมMember</span>
                            <span class="text-xs text-green-500 flex items-center gap-1">
                                0.43% <i class="bi bi-arrow-up"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-sm border border-slate-200 shadow-sm p-6 flex flex-col justify-between h-40">
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 mb-4">
                        <i class="bi bi-mortarboard text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-slate-800">3.456</h4>
                        <div class="flex justify-between items-end">
                            <span class="text-sm text-slate-500">ยอดชม X-Cademy</span>
                            <span class="text-xs text-red-500 flex items-center gap-1">
                                -0.95% <i class="bi bi-arrow-down"></i>
                            </span>
                        </div>
                    </div>
                </div>
  <div class="bg-white rounded-sm border border-slate-200 shadow-sm p-6 flex flex-col justify-between h-40">
    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-4">
        <i class="bi bi-people text-xl"></i>
    </div>
    <div>
        <h4 class="text-2xl font-bold text-slate-800">
            {{ props.totalMembers.toLocaleString() }}
        </h4>
        <div class="flex justify-between items-end">
            <span class="text-sm text-slate-500">สมาชิกทั้งหมด</span>
            <span class="text-xs text-green-500 flex items-center gap-1">
                <i class="bi bi-database-check"></i> Realtime
            </span>
        </div>
    </div>
</div>

              <div class="bg-white rounded-sm border border-slate-200 shadow-sm p-6 flex flex-col justify-between h-40">
    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 mb-4">
        <i class="bi bi-calendar-check text-xl"></i>
    </div>
    <div>
        <h4 class="text-2xl font-bold text-slate-800">
            {{ props.totalEvents.toLocaleString() }}
        </h4>
        <div class="flex justify-between items-end">
            <span class="text-sm text-slate-500">กิจกรรมที่จัดแล้ว</span>
            <span class="text-xs text-green-500 flex items-center gap-1">
                <i class="bi bi-database-check"></i> Realtime
            </span>
        </div>
    </div>
</div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-sm border border-slate-200 shadow-sm p-6">
                    <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap mb-6">
                        <div>
                            <h4 class="text-xl font-bold text-slate-800">Traffic Overview</h4>
                            <p class="text-sm text-slate-500">เปรียบเทียบการเข้าใช้งาน Member vs X-Cademy (7 วันล่าสุด)</p>
                        </div>
                        <div class="flex w-full max-w-45 justify-end">
                            <div class="inline-flex items-center rounded-md bg-slate-100 p-1.5 dark:bg-meta-4">
                                <button class="rounded bg-white py-1 px-3 text-xs font-medium text-black shadow-card hover:bg-white hover:shadow-card dark:bg-boxdark dark:text-white dark:hover:bg-boxdark">
                                    Week
                                </button>
                                <button class="rounded py-1 px-3 text-xs font-medium text-slate-500 hover:bg-white hover:shadow-card dark:text-white dark:hover:bg-boxdark">
                                    Month
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="h-[300px] w-full">
                        <Line :data="chartData" :options="chartOptions" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <Link :href="route('admin.members.index')" class="bg-white p-6 rounded-sm border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="bi bi-person-vcard text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">จัดการสมาชิก</h3>
                        <p class="text-xs text-slate-500">Member Management</p>
                    </div>
                    <i class="bi bi-chevron-right ml-auto text-slate-300"></i>
                </Link>

                <Link :href="route('admin.banners.index')" class="bg-white p-6 rounded-sm border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <i class="bi bi-images text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">จัดการ Banner</h3>
                        <p class="text-xs text-slate-500">Slide & Static</p>
                    </div>
                     <i class="bi bi-chevron-right ml-auto text-slate-300"></i>
                </Link>

                <Link :href="route('admin.events.index')" class="bg-white p-6 rounded-sm border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <i class="bi bi-calendar-event text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">จัดการกิจกรรม</h3>
                        <p class="text-xs text-slate-500">Events System</p>
                    </div>
                     <i class="bi bi-chevron-right ml-auto text-slate-300"></i>
                </Link>

            </div>

        </div>
    </AdminLayout>
</template>

<style scoped>
/* Custom Scrollbar หรือ Font เพิ่มเติม */
</style>