<script setup>
import { Head, Link, } from '@inertiajs/vue3';
import { ChevronLeft } from '@/Components/Icons/solid';

const props = defineProps({
    promotion: Object,
})

</script>

<template>
    <Head title="Promotion" />
    <div class="flex justify-center w-full" >
        <div class="max-w-md w-full flex flex-col min-h-screen">
            <div class="p-3 flex justify-between items-center">
                <Link :href="route('promotion.promotion')">
                    <ChevronLeft />
                </Link>
                
                <div class="text-white text-base font-semibold leading-tight flex items-center" >Promotion</div>
                <div class="w-6 h-6"></div>
            </div>
            <div class="bg-white w-full h-full flex flex-col">
                <img src="https://www.its.ac.id/tmesin/wp-content/uploads/sites/22/2022/07/no-image.png" alt="">

                <div class="p-3 flex flex-col gap-6">
                    <div class="text-gray-900 text-2xl font-semibold">
                        {{ promotion.title }}
                    </div>
                    <div class=" overflow-y-auto" >
                        {{ promotion.description }}
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lobortis porttitor rhoncus. Donec eget congue odio, faucibus laoreet ipsum. Nulla leo nunc, auctor in fringilla ut, semper ut libero. Curabitur aliquam nisl et dolor egestas condimentum. Maecenas vehicula quis lorem vitae efficitur. Phasellus eu malesuada tortor, in commodo lorem. In lacinia quam sapien. Suspendisse scelerisque magna non fringilla faucibus. Mauris commodo sem diam, non pulvinar metus tempus eget. Duis consectetur libero vel interdum venenatis.

Cras neque orci, efficitur sed fringilla quis, congue eget massa. Maecenas facilisis eros vitae velit accumsan, a scelerisque elit porttitor. Cras ullamcorper mauris eu felis posuere efficitur. Ut non tempus nisi, vel feugiat ex. Proin maximus, magna vitae fermentum volutpat, metus nulla semper massa, eget volutpat ante enim ac est. Praesent dictum enim eget convallis pulvinar. Pellentesque malesuada volutpat turpis id finibus. Proin metus odio, iaculis non mauris id, tempor tempor purus. Vestibulum suscipit ante nec dui dignissim, ut accumsan tellus rhoncus. Sed vel leo sed erat viverra ultricies vel vel lacus.

Maecenas in metus faucibus, pretium ipsum et, feugiat erat. In eget dolor in enim pharetra lacinia vitae et elit. Maecenas posuere accumsan magna, eu eleifend lacus. Mauris sit amet mi ligula. Curabitur dapibus rhoncus ullamcorper. Morbi iaculis est ac risus feugiat convallis. Aenean finibus est nec viverra varius. Integer feugiat, dolor id interdum posuere, nunc erat accumsan libero, ac mattis ante sapien et orci. Cras et libero tincidunt, condimentum tellus ac, pharetra ipsum. Fusce non felis non velit fringilla finibus. Mauris enim massa, aliquam ut est vel, faucibus tempus turpis. Vestibulum arcu mi, porttitor vitae finibus ac, pellentesque vitae enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas quam lacus, bibendum sed nisl pretium, rutrum bibendum erat.

Maecenas vulputate at sem id placerat. Fusce gravida imperdiet sapien. Sed convallis enim et scelerisque congue. Sed condimentum ipsum sagittis ullamcorper venenatis. Etiam quis elit rhoncus, posuere ipsum ut, sagittis turpis. Nulla facilisi. Phasellus mattis odio sem, at rhoncus mi pulvinar at. Fusce ultricies nunc tellus, a tincidunt sapien lobortis a. Mauris interdum dapibus ligula, id blandit enim facilisis sit amet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec non fermentum urna.

Integer at leo sed ipsum suscipit fringilla sed sit amet libero. Curabitur consequat lacinia leo, id efficitur ligula dignissim nec. Ut tempus quam non ipsum scelerisque efficitur. Nunc consectetur in lacus in congue. Vestibulum sit amet augue et magna sodales dictum. Cras sed scelerisque neque. Pellentesque finibus tincidunt neque, quis elementum orci laoreet at. Donec vestibulum lobortis aliquet. Nam auctor eros lacus, ac dapibus nisl molestie vel. Aenean egestas rhoncus blandit. Quisque vitae dictum tellus. Nulla nunc tortor, eleifend sit amet lorem vitae, euismod tincidunt odio. Ut tempus, nisi sit amet tincidunt porta, dolor sem malesuada purus, eu fringilla ipsum ligula sit amet libero. Nulla malesuada lectus nec magna sagittis, quis aliquam ipsum volutpat.

Praesent nec justo sit amet mi vulputate venenatis eu et lacus. Nulla euismod est id interdum molestie. Sed finibus felis ut lacus rutrum scelerisque et lobortis nunc. Nunc eu augue at enim tempus facilisis. Donec non gravida tortor. In maximus quam ornare, vulputate nunc ut, luctus risus. Sed ut ipsum et magna mattis varius eget sit amet ipsum. Suspendisse potenti. Ut in facilisis mi, id ullamcorper massa.
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    
    </div>
</template>