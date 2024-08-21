import { Skeleton } from "antd";

const RulesModalSkeleton = () => {

    return (
        <>
            <li className="content-restriction__type__item">
                <button className="content-restriction__type__btn">
                    <Skeleton
                        active={true}
                        paragraph={{
                        rows: 4,
                        }}
                    />
                </button>
            </li>
            <li className="content-restriction__type__item">
                <button className="content-restriction__type__btn">
                    <Skeleton
                        active={true}
                        paragraph={{
                        rows: 4,
                        }}
                    />
                </button>
            </li>
            <li className="content-restriction__type__item">
                <button className="content-restriction__type__btn">
                    <Skeleton
                        active={true}
                        paragraph={{
                        rows: 4,
                        }}
                    />
                </button>
            </li>
            <li className="content-restriction__type__item">
                <button className="content-restriction__type__btn">
                    <Skeleton
                        active={true}
                        paragraph={{
                        rows: 4,
                        }}
                    />
                </button>
            </li>
            <li className="content-restriction__type__item">
                <button className="content-restriction__type__btn">
                    <Skeleton
                        active={true}
                        paragraph={{
                        rows: 4,
                        }}
                    />
                </button>
            </li>
            <li className="content-restriction__type__item">
                <button className="content-restriction__type__btn">
                    <Skeleton
                        active={true}
                        paragraph={{
                        rows: 4,
                        }}
                    />
                </button>
            </li>
        </>                             
    );
}

export default RulesModalSkeleton;