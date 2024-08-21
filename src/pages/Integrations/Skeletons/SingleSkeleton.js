import { Skeleton } from "antd";

const SingleSkeleton = () => {
    return (
        <div class="content-restriction__integrations__list__item">
            <div class="content-restriction__integrations__list__item__header">
                <Skeleton
                    active={true}
                    title={false}
                    paragraph={{
                        rows: 8,
                        width: '100%'
                    }}
                />
            </div>
        </div>               
    );
}

export default SingleSkeleton;