import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RegisterLearnerInvitedComponent } from './register-learner-invited.component';

describe('RegisterLearnerInvitedComponent', () => {
  let component: RegisterLearnerInvitedComponent;
  let fixture: ComponentFixture<RegisterLearnerInvitedComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RegisterLearnerInvitedComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RegisterLearnerInvitedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
