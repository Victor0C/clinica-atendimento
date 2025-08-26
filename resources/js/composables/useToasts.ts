import { toast } from 'vue-sonner';

const useToasts = () => {
    const showToastPromise = <T>(promise: Promise<T>, successCallback: (data: T) => string, errorCallback: (error: unknown) => string) => {
        return toast.promise(promise, {
            loading: 'Carregando...',
            success: (data: any) => successCallback(data),
            error: (error: any) => errorCallback(error),
        });
    };

    const success = (message: string) => {
        toast.success(message);
    };

    const error = (message: string) => {
        toast.error(message);
    };

const showToastManualSuccess = <T>(
    promise: Promise<T>,
    successMessage: string,
    successCallback: (data: T) => void,
    errorCallback: (error: unknown) => string,
) => {
    promise
        .then((data) => {
            toast(successMessage, {
                action: {
                    label: 'Ok',
                    onClick: () => successCallback(data),
                },
                duration: 5000,
                dismissible: true,
                onDismiss: () => successCallback(data),
            });

            // setTimeout(() => successCallback(data), 5000);
        })
        .catch((err) => {
            toast.error(errorCallback(err));
        });
};




    return { showToastPromise, showToastManualSuccess, success, error };
};

export { useToasts };
