import { Skeleton } from "antd";

const ModuleSelectSkeleton = () => {
    return (
        <>
            <div className="content-restriction__single__btn">
                <Skeleton
                active={true}
                title={false}
                paragraph={{
                    rows: 1,
                    width: '100%'
                }}
                />
            </div>
        </>                             
    );
}

export default ModuleSelectSkeleton;