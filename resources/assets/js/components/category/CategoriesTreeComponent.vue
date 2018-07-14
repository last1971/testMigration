<template>
    <div class="container">
        <div v-if="level==0 && $store.state.user.id == 1" class="row mb-2">
            <b-button variant="primary" size="sm" @click="save(0)">Добавить</b-button>
        </div>
        <div v-for="node in nodes">
            <div class="row tree-hover align-items-center">
                    <i v-if="node.lft+1!=node.rgt && node.collapsed" class="tree-collapsed tree-icon ml-0"  @click="toggle(node)"></i>
                    <i v-else-if="!node.collapsed" class="tree-not-collapsed tree-icon ml-0" @click="toggle(node)"></i>
                    <i v-else class="tree-leaf tree-icon ml-0"></i>
                    <div class="ml-2" v-if="node.name" @click="$emit('input',node)">{{node.name.name}}</div>
                    <div class="ml-2" v-else>Редактируется...</div>
                    <i v-if="$store.state.user.id == 1" class="edit-icon tree-icon ml-2" @click="save(node.id,node)"></i>
                    <i v-if="$store.state.user.id == 1" class="add-icon tree-icon ml-2" @click="save(node.id)"></i>
                    <i v-if="$store.state.user.id == 1 && node.lft+1==node.rgt" class="dustbin-icon tree-icon ml-2" @click="remove(node.id)"></i>
            </div>
            <div class="row"  v-if="node.lft+1!=node.rgt && !node.collapsed">
                <categories-tree-component :level="node.level+1" :node_id="node.id" class="ml-2" v-model="exch_value" @input="Back"></categories-tree-component>
            </div>
        </div>
        <category-edit-component v-model="node" :expanded="expanded" ref="edit" v-if="editing" v-on:close="CloseEdit"></category-edit-component>
    </div>
</template>

<script>
    import  bButton from 'bootstrap-vue/es/components/button/button';
    import CategoryEditComponent from "./CategoryEditComponent";
    export default {
        components: {CategoryEditComponent, bButton},
        name: "CategoriesTreeComponent",
        props: ['node_id','level','value'],
        data() {
            return {
                nodes:[],
                node:{id:0,name:{id:0,name:''},article:{id:0,name_id:0,name:{id:0,name:''}},picture:{id:0,path:''}},
                editing:false,
                expanded:0,
                exch_value:{id:0,name:{id:0,name:''},article:{id:0,name_id:0,name:{id:0,name:''}},picture:{id:0,path:''}}
            }
        },
        mounted() {
            this.exch_value = this.value;
            this.$store.dispatch('checkUser');
            this.refresh();
        },
        methods: {
            toggle(node) {
                node.collapsed = !node.collapsed;
                this.editing=false;
            },
            remove(id) {
                axios.delete('categories/' + id)
                    .then(response => {
                        this.refresh();
                    }).catch (error => {});
            },
            refresh() {
                let that = this;
                axios.get('categories',{params: {node_id:that.node_id,level:that.level}})
                    .then(response => {
                        that.nodes = response.data;
                        if (that.node.id!=0) that.toggle(that.node);
                    }).catch(error => {  that.nodes = []});
            },
            save(id,node={id:0,name:{id:0,name:''},article:{id:0,name_id:0,name:{id:0,name:''}},picture:{id:0,path:''}}) {
                this.expanded=id;
                this.node=node;
                this.editing=true;
            },
            CloseEdit() {
                this.editing=false;
                this.refresh();
            },
            Back() {
                this.$emit('input',this.exch_value);
            }
        }
    }
</script>

<style scoped>
    .tree-icon {
        display:inline-block;
        width:10px;
        height:10px;
        background-size: 100%;
    }
    .tree-collapsed {
        background-image: url('/storage/icons/collapsed-tree.svg');
    }
    .tree-not-collapsed {
        background-image: url('/storage/icons/not-collapsed-tree.svg');
    }
    .tree-leaf {
        background-image: url('/storage/icons/tree-leaf.svg');
    }
    .tree-hover .add-icon {
        display: none;
    }
    .tree-hover:hover .add-icon {
        display: block;
    }
    .tree-hover .dustbin-icon {
        display: none;
    }
    .tree-hover:hover .dustbin-icon {
        display: block;
    }
    .tree-hover .edit-icon {
        display: none;
    }
    .tree-hover:hover .edit-icon {
        display: block;
    }
</style>