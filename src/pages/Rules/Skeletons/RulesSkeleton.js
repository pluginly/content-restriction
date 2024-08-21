import { Skeleton } from "antd";

const RulesSkeleton = () => {
    return (
        <>
            <tr>
                <td>
                    <Skeleton
                        active={true}
                        title={false}
                        paragraph={{
                            rows: 1,
                            width: '100%'
                        }}
                    />
                </td>
                <td>
                    <Skeleton
                        active={true}
                        title={false}
                        paragraph={{
                            rows: 1,
                            width: '100%'
                        }}
                    />
                </td>
                <td>
                    <Skeleton
                        active={true}
                        title={false}
                        paragraph={{
                            rows: 1,
                            width: '100%'
                        }}
                    />
                </td>
                <td>
                    <Skeleton
                        active={true}
                        title={false}
                        paragraph={{
                            rows: 1,
                            width: '100%'
                        }}
                    />
                </td>
            </tr>
        </>                             
    );
}

export default RulesSkeleton;