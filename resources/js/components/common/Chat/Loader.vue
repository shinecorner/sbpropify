<template>
    <content-loader :width="320" :height="192" :speed="2" primaryColor="#f3f3f3" secondaryColor="#ecebeb" preserveAspectRatio="xMinYMin meet" style="width: 320px;">
        <circle cx="16" cy="16" r="16" /> 
		<rect x="40" y="12" rx="4" ry="4" width="160" height="8" /> 
		<circle cx="16" cy="56" r="16" /> 
		<rect x="40" y="52" rx="4" ry="4" width="106" height="8" /> 
		<circle cx="16" cy="96" r="16" /> 
		<rect x="40" y="92" rx="4" ry="4" width="280" height="8" /> 
		<circle cx="16" cy="136" r="16" /> 
		<rect x="40" y="132" rx="4" ry="4" width="160" height="8" /> 
		<circle cx="16" cy="176" r="16" />
		<rect x="40" y="172" rx="4" ry="4" width="80" height="8" />
    </content-loader>
</template>

<script>
    import {ContentLoader} from "vue-content-loader"

    export default {
		inheritAttrs: false,
        components: {
            ContentLoader
		}
    }
</script>
