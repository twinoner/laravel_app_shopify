<template>
    <button @click="install">Install app</button>
</template>
<script>
export default {
    props: { shopDomain: { type: String, default: '' } },
    methods: {
        install() {
            const shop = this.shopDomain || prompt('Enter shop domain (example.myshopify.com)')
            if (!shop) return
            window.location.href = `/auth/install?shop=${encodeURIComponent(shop)}`
        }
    }
}
</script>