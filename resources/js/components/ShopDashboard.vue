<template>
    <div>
        <h2>{{ shop.shopify_domain }}</h2>
        <p>Installed at: {{ shop.installed_at }}</p>
    </div>
</template>
<script>
import { useQuery, gql } from '@vue/apollo-composable'
export default {
    props: { domain: String },
    setup(props) {
        const SHOP_QUERY = gql`query Shop($domain: String!) { shop(domain: $domain) { id shopify_domain installed_at } }`
        const { result } = useQuery(SHOP_QUERY, { domain: props.domain })
        return { shop: result }
    }
}
</script>