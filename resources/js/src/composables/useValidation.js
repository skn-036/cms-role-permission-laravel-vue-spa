import * as yup from 'yup';

const useValidation = () => {
    const getData = (schema, value) => {
        if (!schema?.fields || !Object.keys(schema?.fields)?.length) {
            return value;
        }

        return Object.entries(schema?.fields || {}).reduce((r, field) => {
            const [key, val] = field;
            if ('fields' in val && Object.keys(val)?.length) {
                if (value && typeof value === 'object' && key in value) {
                    return { ...r, [key]: getData(val, value[key]) };
                }
                return r;
            } else {
                const keyVal =
                    value && typeof value === 'object' ? value[key] : value;

                return { ...r, [key]: keyVal };
            }
        }, {});
    };

    const runYupValidation = async (schema, value) => {
        try {
            await schema.validate(value, {
                abortEarly: false,
            });

            return {
                validated: true,
                data: getData(schema, value),
                errors: {},
            };
        } catch (error) {
            if (error instanceof yup.ValidationError) {
                return {
                    validated: false,
                    data: {},
                    errors: error.inner.reduce((prev, err, index) => {
                        const { path, message } = err;
                        if (!message) return prev;
                        return { ...prev, [path ? path : index]: message };
                    }, {}),
                };
            }

            return {
                validated: true,
                data: getData(schema, value),
                errors: {},
            };
        }
    };

    const requiredIfExists = (value, { createError, path }) => {
        if (value === undefined) return true;
        if (!value) return createError({ message: `${path} is required` });
        return true;
    };

    return {
        runYupValidation,
        requiredIfExists,
    };
};

export default useValidation;
