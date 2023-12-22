<script  setup lang="ts">
import axios from 'axios'
import { debounce } from 'lodash'
import { onMounted, ref } from 'vue'
import VueSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    modelValue: {
        type: null,
        required: true,
    },
    options: {
        type: Array,
        required: false,
    },
    placeholder: {
        type: String,
        required: false,
    },
    preload: {
        type: Boolean,
        required: false,
        default: false,
    },
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: false,
    },
})

const emit = defineEmits(['update:modelValue', 'optionSelected'])

const selectOptions = ref([])
selectOptions.value = props.options ?? []

const onSearch = debounce(onSearchDebounced, 300, { maxWait: 1000 })
const selectedOption = ref(getSelectedOption())

onMounted(() => {
    if (props.preload && selectOptions.value.length === 0) {
        updateOptions('', () => {
            // loading hidden in preload
        })
    }
})

async function onSearchDebounced(search, loading) {
    await updateOptions(search.trim(), loading)
}

async function updateOptions(search, loading) {
    if (!props.href) {
        selectOptions.value = []
        return
    }

    loading(true)

    let response = await axios.get(props.href, {
        params: {
            searchTerm: search,
        },
    })
    selectOptions.value = response.data

    loading(false)
}

function getSelectedOption() {
    if (props.modelValue) {
        return selectOptions.value.find((option) => option.id === props.modelValue)
    }
    return null
}

function updateModelValue() {
    emit('update:modelValue', selectedOption.value?.id)
}

</script>

<template>
    <div>
        <label :for="name ?? id" class="form-label">{{ label }}</label>
        <VueSelect
            :id="id"
            v-model="selectedOption"
            :placeholder="placeholder ?? 'Selecione uma Opção'"
            :options="selectOptions"
            label="text"
            searchable
            :filterable="false"
            :name="name ?? id"
            @update:modelValue="updateModelValue"
            @search="onSearch">
            <template #no-options="{ search, searching }">
                <template v-if="searching">
                    Nenhuma Opção encontrada para <em>{{ search }}</em>.
                </template>
                <em v-else>Digite para pesquisar</em>
            </template>
        </VueSelect>
    </div>
</template>
