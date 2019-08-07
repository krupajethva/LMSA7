import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InboxPreviewNewComponent } from './inbox-preview-new.component';

describe('InboxPreviewNewComponent', () => {
  let component: InboxPreviewNewComponent;
  let fixture: ComponentFixture<InboxPreviewNewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InboxPreviewNewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InboxPreviewNewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
