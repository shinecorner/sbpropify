<template>
    <div class="select-container">
        <el-select class="select-icon" :style="{maxWidth: maxWidth + 60 + 'px'}" :class="column.class" @change="$emit('change', vModel)" v-model="vModel">
            <template slot="prefix">
                <i class="icon-dot-circled" :class="vModel == 1 ? 'icon-success':'icon-danger'"  v-if="column.ShowCircleIcon"></i>
            </template>
            <el-option
                :key="item.id"
                :label="item.name"
                :value="item.id"
                v-for="item in column.select.data">
                <i class="icon-dot-circled" :class="item.id == 1 ? 'icon-success':'icon-danger'"  v-if="column.ShowCircleIcon"></i> {{item.name}}
            </el-option>
        </el-select>
        <span :id="spanKey+selectValue" style="visibility: hidden" ></span>
    </div>
</template>
<script>
export default {
    data() {
        return {
            vModel: this.selectValue,
            maxWidth: 50
        }
    },
    props: {
        selectClass: {
            type: String,
            default: () => {
                return '';
            }
        },
        column: {
            type: Object,
            required: true
        },
        spanKey : {
            type: String,
            required: true
        },
        selectValue : {
            type: Number,
            required: true
        }
    },
    methods: {
        getTextWidth(text) { 
  
            var spanText = document.getElementById(this.spanKey+this.selectValue);
            spanText.style.position = 'absolute'; 
            spanText.style.left = '0';
            spanText.style.whiteSpace = 'no-wrap'; 
            spanText.innerHTML = text; 
  
            var width = Math.ceil(spanText.clientWidth); 
            return width;
        },
        fitWidth() {
            this.column.select.data.map((item) => {
                if(this.vModel == item.id) {
                    this.maxWidth = this.getTextWidth(item.name);
                }
            });
        }
    },
    updated() {
       this.fitWidth();
    },
    mounted() {
        this.fitWidth();
    }
}
</script>
<style scoped>
    .icon-success {
        color: #5fad64;
    }

    .icon-danger {
        color: #dd6161;
    }
</style>