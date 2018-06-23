<template>
    <form class="form-inline m-2 m-md-2">
        <input class="form-control m-sm-2" type="search" placeholder="Что ищем" aria-label="Поиск:" v-model="filterText" @keyup.enter="doFilter">
        <button class="btn btn-outline-success m-2 my-sm-2" @click.prevent="doFilter">Вперед</button>
        <button class="btn btn-outline-danger m-2 my-sm-2" @click.prevent="resetFilter">Очистить</button>
    </form>
</template>

<script>
    export default {
        data () {
            return {
                filterText: ''
            }
        },
        methods: {
            doFilter () {
                this.$emit('filterChange',this.filterText)
            },
            resetFilter () {
                this.filterText = ''  // clear the text in text input
                this.$emit('filterChange',this.filterText)
            }
        }
    }
</script>