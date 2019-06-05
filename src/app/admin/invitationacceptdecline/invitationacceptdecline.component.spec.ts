import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InvitationacceptdeclineComponent } from './invitationacceptdecline.component';

describe('InvitationacceptdeclineComponent', () => {
  let component: InvitationacceptdeclineComponent;
  let fixture: ComponentFixture<InvitationacceptdeclineComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InvitationacceptdeclineComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InvitationacceptdeclineComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
