import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const useAppRouter = () => {
    const route = useRoute();
    const router = useRouter();

    // Route Params
    const routeParams = computed(() => route.params);
    const routeQuery = computed(() => route.query);
    const routeName = computed(() => route.name);
    const routeMeta = computed(() => route.meta);

    const isActiveRoute = (givenRoute, allowChildMatch = true) => {
        const resolved = router.resolve(givenRoute);
        if (allowChildMatch) {
            return route.path.includes(resolved.path);
        }
        return Boolean(resolved.path === route.path);
    };

    const resolvedRoute = (route) => router.resolve(route);

    const pushToRoute = async (givenRoute) => {
        const resolved = router.resolve(givenRoute);

        let success = null;
        if (resolved && resolved.fullPath !== route.fullPath)
            success = await router.push(resolved);
        return success;
    };

    return {
        route,
        router,
        routeParams,
        routeQuery,
        routeName,
        routeMeta,
        isActiveRoute,
        resolvedRoute,
        pushToRoute,
    };
};

export default useAppRouter;
