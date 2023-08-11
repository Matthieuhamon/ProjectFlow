import React from "react";
import {Card, Col, Container, Row} from "react-bootstrap";
import {patch} from "../../../functions/api";
import CardIssueDetails from "./CardIssueDetails";
import StackIssueStatusType from "./StackIssueStatusType";
import MediaViewer from "../MediaViewer";
import IssueAttachments from "./IssueAttachments";
import ButtonAttach from "../attachment/ButtonAttach";
import {EditText} from "react-edit-text";

export default function Issue({ serializedIssue, issueStatuses, issueTypes }) {
    const [issue, setIssue] = React.useState(JSON.parse(serializedIssue));
    const [openMediaViewer, setOpenMediaViewer] = React.useState(false);
    const [selectedAttachment, setSelectedAttachment] = React.useState(null);

    const handleStatusChange = (e) => {
        const selectedStatus = e.target.value;

        patch('issues', issue.id, {
            status: selectedStatus
        }).then(() => {
            setIssue({...issue, status: selectedStatus});
        });
    }

    const handleSave = (e) => {
        const body = {};

        body[e.name] = e.value;

        patch('issues', issue.id,body)
            .then(response => response.json())
            .then(() => {
                document.title = `[${issue.id}] ${e.value} - TaskSphere`;

            });
    }

    const handleTypeChange = (e) => {
        const selectedType = e.target.value;

        patch('issues', issue.id, {
            type: selectedType
        }).then(() => {
            setIssue({...issue, type: selectedType});
        });
    }

    const showMediaViewer = (attachment) => {
        setSelectedAttachment(attachment);
        setOpenMediaViewer(true);
    }

    const updateSummaryValue = (e) => {
        const updatedSummary = e.target.value;

        setIssue({...issue, summary: updatedSummary});
    }

    return (
        <Container className="mt-5">
            <Row>
                <Col sm={12} md={8}>
                    <Card>
                        <Card.Body>
                            <Card.Title className="content-editable issue-summary">
                                <EditText className="w-100" inputClassName="w-100" name="summary" onChange={updateSummaryValue} onSave={handleSave} value={issue.summary} />
                            </Card.Title>
                            <div className="issue-buttons my-3">
                                <ButtonAttach issue={issue} setIssue={setIssue} />
                            </div>
                            <Card.Text className="fw-bold">Description</Card.Text>
                            <hr />
                            <div className="content-editable issue-description">
                                <p dangerouslySetInnerHTML={{__html: issue.description ?  issue.description : '<span class="text-muted">Add a description...</span>'}}></p>
                            </div>
                            {issue.attachments.length > 0 && (
                                <IssueAttachments issue={issue} showMediaViewer={showMediaViewer} />
                            )}
                        </Card.Body>
                    </Card>
                </Col>
                <Col sm={12} md={4}>
                    <StackIssueStatusType
                        handleStatusChange={handleStatusChange}
                        handleTypeChange={handleTypeChange}
                        issue={issue}
                        issueTypes={issueTypes}
                        issueStatuses={issueStatuses}/>
                    <CardIssueDetails issue={issue} setIssue={setIssue} />
                </Col>
            </Row>
            <MediaViewer
                attachmentPath={selectedAttachment?.path}
                openMediaViewer={openMediaViewer}
                setOpenMediaViewer={setOpenMediaViewer}
            />
        </Container>
    )
}