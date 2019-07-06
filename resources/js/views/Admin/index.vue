<template>
    <div>
        <heading class="custom-heading" icon="ti-home" title="Dashboard"/>
        <el-row :gutter="24" style="margin-bottom: 24px;" type="flex">
            <el-col :span="6">
                <raw-grid-statistics-card :data="statistics"/>
            </el-col>
            <!--<el-col :span="6">-->
            <!--<el-row>-->
            <!--<el-col :span="24" style="margin-bottom: 12px;">-->
            <!--<colored-statistics-card -->
            <!--color="#0F52BC"-->
            <!--icon="ti-timer" -->
            <!--title="Bounce rate" -->
            <!--value="32.16%" -->
            <!--description="65.45% on average time" />-->
            <!--</el-col>-->
            <!--<el-col :span="24" style="margin-bottom: 12px;">-->
            <!--<colored-statistics-card -->
            <!--color="#27ae60"-->
            <!--icon="ti-timer" -->
            <!--title="Bounce rate" -->
            <!--value="32.16%" -->
            <!--description="65.45% on average time" />-->
            <!--</el-col>-->
            <!--<el-col :span="24">-->
            <!--<colored-statistics-card -->
            <!--color="#582DB7"-->
            <!--icon="ti-timer" -->
            <!--title="Bounce rate" -->
            <!--value="32.16%" -->
            <!--description="65.45% on average time" />-->
            <!--</el-col> -->
            <!--</el-row>-->
            <!--</el-col>-->
            <!--<el-col :span="6">-->
            <!--<el-row>-->
            <!--<el-col :span="24" style="margin-bottom: 24px;">-->
            <!--<progress-statistics-card-->
            <!--value="64"-->
            <!--title="Activities completed"-->
            <!--description="3 more than in August"-->
            <!--color="#f39c12" />-->
            <!--</el-col>-->
            <!--<el-col :span="24">-->
            <!--<raw-grid-statistics-card :data="liteStatistics" />-->
            <!--</el-col>-->
            <!--</el-row>-->
            <!--</el-col>-->
            <!--<el-col :span="6">-->
            <!--<el-row :gutter="12" style="margin-bottom: 12px;">-->
            <!--<el-col :span="12">-->
            <!--<circular-progress-statistics-card :percentage="56" title="Lorep ipsum"  />-->
            <!--</el-col>-->
            <!--<el-col :span="12">-->
            <!--<circular-progress-statistics-card-->
            <!--:percentage="88"-->
            <!--color="#94579F"-->
            <!--title="Lorep ipsum" />-->
            <!--</el-col>-->
            <!--</el-row>-->
            <!--<colored-statistics-card-->
            <!--color="#CA004A"-->
            <!--icon="ti-timer"-->
            <!--title="Bounce rate"-->
            <!--value="32.16%"-->
            <!--description="65.45% on average time" />-->
            <!--</el-col>-->
        </el-row>
        <!--<el-row :gutter="24">-->
        <!--<el-col :span="12">-->
        <!--<weather-card />-->
        <!--</el-col>-->
        <!--</el-row>-->
    </div>
</template>

<script>
    import Heading from 'components/Heading';
    import RawGridStatisticsCard from 'components/RawGridStatisticsCard';
    import ColoredStatisticsCard from 'components/ColoredStatisticsCard.vue';
    import ProgressStatisticsCard from 'components/ProgressStatisticsCard.vue';
    import CircularProgressStatisticsCard from 'components/CircularProgressStatisticsCard.vue';

    export default {
        name: 'AdminDashboard',
        components: {
            Heading,
            RawGridStatisticsCard,
            ColoredStatisticsCard,
            ProgressStatisticsCard,
            CircularProgressStatisticsCard
        },
        data() {
            return {
                statistics: [{
                    icon: 'ti-shopping-cart',
                    color: '#f06292',
                    value: 648,
                    description: 'Requests open'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#26c6da',
                    value: '47.5k',
                    description: 'Requests pending'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#9575cd',
                    value: 764,
                    description: 'Requests done'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#1a237e',
                    value: 256,
                    description: 'Requests archived'
                }],
                liteStatistics: [{
                    icon: 'ti-shopping-cart',
                    color: '#9575cd',
                    value: 764,
                    description: 'Daily earnings'
                }, {
                    icon: 'ti-shopping-cart',
                    color: '#1a237e',
                    value: 256,
                    description: 'Products'
                }]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .custom-heading {
        margin-bottom: 2em;
    }
</style>
