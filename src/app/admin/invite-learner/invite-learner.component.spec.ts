import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InviteLearnerComponent } from './invite-learner.component';

describe('InviteLearnerComponent', () => {
  let component: InviteLearnerComponent;
  let fixture: ComponentFixture<InviteLearnerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InviteLearnerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InviteLearnerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
