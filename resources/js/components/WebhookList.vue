<template>
    <div>
        <h3>Webhook Events</h3>
        <ul>
            <li v-for="e in events" :key="e.id">
                <strong>{{ e.topic }}</strong> — <small>{{ e.created_at }}</small>
                <pre>{{ JSON.stringify(e.payload, null, 2) }}</pre>
            </li>
        </ul>
    </div>
</template>
<script>
import { useQuery, gql } from '@vue/apollo-composable'
export default {
    props: { shopId: Number },
    setup(props) {
        const EVENTS = gql`query Events($shopId: ID!) { webhookEvents(shopId: $shopId) { id topic payload created_at } }`
        const { result } = useQuery(EVENTS, { shopId: props.shopId })
        return { events: result }
    }
}
</script>