<script setup>
import { toRefs, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    variant: {
        type: String,
        default: 'primary',
        validator(value) {
            return ['primary', 'secondary', 'tertiary', 'danger', 'transparent'].includes(value)
        },
    },
    type: {
        type: String,
        default: 'submit',
    },
    size: {
        type: String,
        default: 'base',
        validator(value) {
            return ['sm', 'base', 'lg', 'lgNp'].includes(value)
        },
    },
    squared: {
        type: Boolean,
        default: false,
    },
    pill: {
        type: Boolean,
        default: false,
    },
    href: {
        type: String,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    iconOnly: {
        type: Boolean,
        default: false,
    },
    srText: {
        type: String || undefined,
        default: undefined,
    },
    external: {
        type: Boolean,
        default: false,
    }
})

const emit = defineEmits(['click'])

const { type, variant, size, squared, pill, href, iconOnly, srText, external } = props

const { disabled } = toRefs(props)

const baseClasses = [
    'inline-flex items-center transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-dark-eval-2',
]

const variantClasses = (variant) => ({
    'bg-primary-900 text-white font-medium hover:bg-primary-800 focus:ring-primary-600 shadow-lg': variant === 'primary',
    'bg-primary-50 text-primary-900 hover:bg-primary-25 focus:ring-primary-500 dark:bg-dark-eval-1 dark:hover:bg-dark-eval-2 dark:hover:text-primary-700 disabled:bg-primary-100':
        variant === 'secondary',
    'bg-transparent border border-primary-800 rounded-[5px] text-primary-900 focus:ring-green-500 shadow-lg': variant === 'tertiary',
    'bg-primary-600 text-white hover:bg-primary-500 focus:ring-red-500 shadow-lg': variant === 'danger',
    'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500 shadow-lg': variant === 'warning',
    'bg-transparent rounded-full shadow-lg': variant === 'transparent',
})

const classes = computed(() => [
    ...baseClasses,
    iconOnly
        ? {
                'p-1.5': size == 'sm',
                'p-2': size == 'base',
                'p-3': size == 'lg',
                'p-1': size == 'lgNp',
            }
        : {
                'px-2.5 py-1.5 text-sm': size == 'sm',
                'px-4 py-2 text-sm': size == 'base',
                'px-6 py-3 text-base': size == 'lg',
            },
    variantClasses(variant),
    {
        'rounded-md': !squared && !pill,
        'rounded-full': pill,
    },
    {
        'pointer-events-none opacity-50': href && disabled.value,
    },
])

const iconSizeClasses = [
    {
        'w-5 h-5': size == 'sm',
        'w-3 h-3': size == 'base',
        'w-5 h-5': size == 'lg',
    },
]

const handleClick = (e) => {
    if (disabled.value) {
        e.preventDefault()
        e.stopPropagation()
        return
    }
    emit('click', e)
}

const Tag = external ?  'a' : Link
</script>

<template>
    <component
        :is="Tag"
        v-if="href"
        :href="!disabled ? href : null"
        :class="classes"
        :aria-disabled="disabled.toString()"
    >
        <span
            v-if="srText"
            class="sr-only"
        >
            {{ srText }}
        </span>

        <slot :iconSizeClasses="iconSizeClasses" />
    </component>

    <button
        v-else
        :type="type"
        :class="classes"
        @click="handleClick"
        :disabled="disabled"
    >
        <span
            v-if="srText"
            class="sr-only"
        >
            {{ srText }}
        </span>

        <slot :iconSizeClasses="iconSizeClasses" />
    </button>
</template>