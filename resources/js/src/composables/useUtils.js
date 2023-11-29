const useUtils = () => {
    const stringCapitalize = (string) =>
        string?.charAt(0).toUpperCase() + string?.slice(1).toLowerCase();

    const isObject = (data) => {
        if (typeof data === 'object' && !Array.isArray(data) && data !== null)
            return true;
        return false;
    };

    const isEmptyObject = (obj) => {
        return Object.keys(obj).length === 0;
    };

    const omitPropsFromObject = (object, omittingProps = []) => {
        if (!omittingProps || !omittingProps.length) return object;
        return Object.entries(object).reduce((fields, field) => {
            if (!omittingProps.includes(field[0]))
                fields = { ...fields, [field[0]]: field[1] };
            return fields;
        }, {});
    };

    const filterPropsFromObject = (object, filteringProps = []) => {
        if (!filteringProps || !filteringProps.length) return object;
        return Object.entries(object).reduce((fields, field) => {
            if (filteringProps.includes(field[0]))
                fields = { ...fields, [field[0]]: field[1] };
            return fields;
        }, {});
    };

    return {
        stringCapitalize,
        isObject,
        isEmptyObject,
        omitPropsFromObject,
        filterPropsFromObject,
    };
};

export default useUtils;
